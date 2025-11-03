using AspNetCoreHero.ToastNotification.Abstractions;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using Pet_Shop2.Extensions;
using Pet_Shop2.Models;
using Pet_Shop2.ModelsView;

namespace Pet_Shop2.Controllers
{
    [Authorize]
    public class CheckoutController : Controller
    {
        private readonly PetShopContext _context;
        private readonly INotyfService _notyfService;

        public CheckoutController(PetShopContext context, INotyfService notyfService)
        {
            _context = context;
            _notyfService = notyfService;
        }

        // GET: Checkout
        public IActionResult Index()
        {
            var customerId = HttpContext.Session.GetString("CustomerId");
            if (string.IsNullOrEmpty(customerId))
            {
                _notyfService.Error("Vui lòng đăng nhập để thanh toán!");
                return RedirectToAction("Login", "Cus_Account");
            }

            // Get cart items
            var cartItems = HttpContext.Session.Get<List<CartItem>>("GioHang");
            if (cartItems == null || !cartItems.Any())
            {
                _notyfService.Warning("Giỏ hàng của bạn đang trống!");
                return RedirectToAction("Index", "ShoppingCart");
            }

            // Prepare ViewBag data
            ViewBag.Provinces = _context.Locations.ToList();
            ViewBag.CartItems = cartItems;
            ViewBag.CartTotal = cartItems.Sum(x => x.TotalMoney);
            ViewBag.CustomerId = customerId;

            // Get customer account
            var customer = _context.Accounts.FirstOrDefault(x => x.Id == int.Parse(customerId));
            if (customer != null)
            {
                ViewBag.CustomerAccount = customer;
            }

            return View(customer);
        }

        // POST: Process checkout
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ProcessOrder(CheckoutViewModel model)
        {
            try
            {
                var customerId = HttpContext.Session.GetString("CustomerId");
                if (string.IsNullOrEmpty(customerId))
                {
                    return Json(new { success = false, message = "Phiên đăng nhập đã hết hạn!" });
                }

                var cartItems = HttpContext.Session.Get<List<CartItem>>("GioHang");
                if (cartItems == null || !cartItems.Any())
                {
                    return Json(new { success = false, message = "Giỏ hàng trống!" });
                }

                // Validate model
                if (!ModelState.IsValid)
                {
                    return Json(new { success = false, message = "Thông tin không hợp lệ!" });
                }

                // Get customer account
                var customer = await _context.Accounts.FindAsync(int.Parse(customerId));
                if (customer == null)
                {
                    return Json(new { success = false, message = "Không tìm thấy thông tin khách hàng!" });
                }

                // Update customer address if provided
                if (!string.IsNullOrEmpty(model.Province) && !string.IsNullOrEmpty(model.District) && !string.IsNullOrEmpty(model.Ward))
                {
                    var province = await _context.Locations.FindAsync(model.ProvinceId);
                    var district = await _context.Districts.FindAsync(model.DistrictId);
                    var ward = await _context.Wards.FindAsync(model.WardId);

                    var fullAddress = $"{province?.Name}, {district?.Name}, {ward?.Name}, {model.StreetAddress}";
                    
                    customer.Location = province?.Name;
                    customer.District = district?.Name;
                    customer.Ward = ward?.Name;
                    customer.Address = fullAddress;
                }

                // Create order
                var order = new Order
                {
                    AccountId = customer.Id,
                    OrderDate = DateTime.Now,
                    ShipDate = DateTime.Now.AddDays(3),
                    Deleted = false,
                    Paid = false,
                    Note = model.OrderNote ?? "",
                    TransctStatusId = 1, // Pending status
                    Address = customer.Address,
                    TotalAmount = cartItems.Sum(x => x.TotalMoney)
                };

                _context.Orders.Add(order);
                await _context.SaveChangesAsync();

                // Create order details
                foreach (var item in cartItems)
                {
                    var orderDetail = new OrderDetail
                    {
                        OrderId = order.Id,
                        ProductId = item.Product?.Id,
                        Quantity = item.amount,
                        Total = (decimal)item.TotalMoney,
                        Price = item.Product?.Price ?? 0
                    };

                    _context.OrderDetails.Add(orderDetail);
                }

                await _context.SaveChangesAsync();

                // Clear cart
                HttpContext.Session.Remove("GioHang");

                _notyfService.Success("Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.");

                return Json(new { 
                    success = true, 
                    orderId = order.Id,
                    message = "Đặt hàng thành công!"
                });
            }
            catch (Exception ex)
            {
                _notyfService.Error("Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!");
                return Json(new { success = false, message = "Có lỗi xảy ra khi đặt hàng!" });
            }
        }

        // GET: Order confirmation
        public async Task<IActionResult> Confirmation(int orderId)
        {
            var customerId = HttpContext.Session.GetString("CustomerId");
            if (string.IsNullOrEmpty(customerId))
            {
                return RedirectToAction("Login", "Cus_Account");
            }

            var order = await _context.Orders
                .Include(o => o.OrderDetails)
                .ThenInclude(od => od.Product)
                .FirstOrDefaultAsync(o => o.Id == orderId && o.AccountId == int.Parse(customerId));

            if (order == null)
            {
                _notyfService.Error("Không tìm thấy đơn hàng!");
                return RedirectToAction("Index", "Home");
            }

            return View(order);
        }

        // AJAX: Get districts by province
        [HttpGet]
        public async Task<IActionResult> GetDistricts(int provinceId)
        {
            var districts = await _context.Districts
                .Where(d => d.LocationId == provinceId)
                .Select(d => new { id = d.Id, name = d.Name })
                .ToListAsync();

            return Json(districts);
        }

        // AJAX: Get wards by district
        [HttpGet]
        public async Task<IActionResult> GetWards(int districtId)
        {
            var wards = await _context.Wards
                .Where(w => w.DistrictId == districtId)
                .Select(w => new { id = w.WardId, name = w.Name })
                .ToListAsync();

            return Json(wards);
        }

        // GET: Calculate shipping fee (if needed)
        [HttpGet]
        public IActionResult CalculateShipping(int provinceId, int districtId, int wardId)
        {
            // Basic shipping calculation - can be enhanced
            var shippingFee = 30000; // Default fee

            // You can implement more complex logic here based on location
            if (provinceId == 1) // Ho Chi Minh City (example)
            {
                shippingFee = 20000;
            }
            else if (provinceId == 2) // Hanoi (example)
            {
                shippingFee = 25000;
            }

            return Json(new { shippingFee = shippingFee });
        }
    }

    // ViewModel for checkout
    public class CheckoutViewModel
    {
        public string? OrderNote { get; set; }
        public int ProvinceId { get; set; }
        public string? Province { get; set; }
        public int DistrictId { get; set; }
        public string? District { get; set; }
        public int WardId { get; set; }
        public string? Ward { get; set; }
        public string? StreetAddress { get; set; }
        public string? PaymentMethod { get; set; }
    }
}