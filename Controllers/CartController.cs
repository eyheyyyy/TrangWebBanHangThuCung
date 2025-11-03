using AspNetCoreHero.ToastNotification.Abstractions;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Pet_Shop2.Models;
using Pet_Shop2.ModelsView;

namespace Pet_Shop2.Controllers
{
    [Authorize]
    public class CartController : Controller
    {
        private readonly PetShopContext db;
        public INotyfService notyfService { get; }

        public CartController(PetShopContext db, INotyfService notyfService)
        {
            this.db = db;
            this.notyfService = notyfService;
        }

        public List<CartItem> GioHang
        {
            get
            {
                var gh = HttpContext.Session.Get<List<CartItem>>("GioHang");
                if (gh == default(List<CartItem>))
                {
                    gh = new List<CartItem>();
                }
                return gh;
            }
        }

        [HttpPost]
        [AllowAnonymous]
        public IActionResult AddToCart(int productID, int? amount)
        {
            List<CartItem> gioHang = GioHang;
            
            // Thêm sản phẩm vào giỏ hàng
            CartItem? item = gioHang.SingleOrDefault(x => x.Product?.Id == productID);
            if (item != null) // đã tồn tại => cập nhật số lượng
            {
                if (amount.HasValue) 
                    item.amount += amount.Value;
                else 
                    item.amount++;
            }
            else
            {
                Product? prd = db.Products.SingleOrDefault(x => x.Id == productID);
                if (prd != null)
                {
                    item = new CartItem
                    {
                        Product = prd,
                        amount = amount.HasValue ? amount.Value : 1,
                    };
                    gioHang.Add(item);
                }
            }

            // Lưu lại session
            HttpContext.Session.Set<List<CartItem>>("GioHang", gioHang);
            notyfService.Success("Thêm sản phẩm thành công!");
            
            return Json(new { success = true, cartCount = gioHang.Count });
        }

        [HttpPost]
        [AllowAnonymous]
        public IActionResult UpdateCartQuantity(int productID, int amount)
        {
            List<CartItem> gioHang = GioHang;
            CartItem? item = gioHang.SingleOrDefault(x => x.Product?.Id == productID);
            
            if (item != null && amount > 0)
            {
                item.amount = amount;
            }

            // Lưu lại session
            HttpContext.Session.Set<List<CartItem>>("GioHang", gioHang);
            
            return Json(new { success = true, newTotal = item?.TotalMoney ?? 0 });
        }

        [HttpPost]
        [AllowAnonymous]
        public IActionResult ReduceFromCart(int productID, int? amount = 1)
        {
            List<CartItem> gioHang = GioHang;
            CartItem? item = gioHang.SingleOrDefault(x => x.Product?.Id == productID);
            
            if (item != null) // đã tồn tại => giảm số lượng
            {
                if (item.amount > 1) 
                    item.amount -= amount.Value;
                else
                    gioHang.Remove(item); // Xóa nếu số lượng <= 1
            }

            // Lưu lại session
            HttpContext.Session.Set<List<CartItem>>("GioHang", gioHang);
            
            return Json(new { success = true, cartCount = gioHang.Count });
        }

        [HttpPost]
        [AllowAnonymous]
        public IActionResult RemoveFromCart(int productID)
        {
            List<CartItem> gioHang = GioHang;
            if (gioHang != null)
            {
                CartItem? item = gioHang.SingleOrDefault(x => x.Product?.Id == productID);
                if (item != null)
                {
                    gioHang.Remove(item);
                    notyfService.Success("Đã xóa sản phẩm khỏi giỏ hàng!");
                }
            }

            // Lưu lại session
            HttpContext.Session.Set<List<CartItem>>("GioHang", gioHang);
            
            return Json(new { success = true, cartCount = gioHang.Count });
        }

        [HttpPost]
        [AllowAnonymous]
        public IActionResult ClearCart()
        {
            List<CartItem>? gioHang = null;
            
            // Xóa session
            HttpContext.Session.Set<List<CartItem>>("GioHang", gioHang);
            notyfService.Success("Đã xóa toàn bộ giỏ hàng!");
            
            return Json(new { success = true });
        }

        [AllowAnonymous]
        public IActionResult Index()
        {
            var CusID = HttpContext.Session.GetString("CustomerId");
            if (CusID != null)
                ViewBag.Acc = db.Accounts.SingleOrDefault(x => x.Id == int.Parse(CusID));
            
            var lsCart = GioHang;
            ViewBag.CusID = HttpContext.Session.GetString("CustomerId");
            ViewBag.CartTotal = lsCart.Sum(x => x.TotalMoney);
            
            return View(lsCart);
        }

        [HttpGet]
        [AllowAnonymous]
        public IActionResult GetCartCount()
        {
            var cartCount = GioHang.Count;
            return Json(new { count = cartCount });
        }

        [HttpGet]
        [AllowAnonymous]
        public IActionResult GetCartTotal()
        {
            var cartTotal = GioHang.Sum(x => x.TotalMoney);
            return Json(new { total = cartTotal });
        }
    }
}