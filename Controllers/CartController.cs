using AspNetCoreHero.ToastNotification.Abstractions;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Pet_Shop2.Extensions;
using Pet_Shop2.Models;
using Pet_Shop2.ModelsView;

namespace Pet_Shop2.Controllers
{
    public class CartController : Controller
    {
        private readonly PetShopContext _context;
        private readonly INotyfService _notyfService;

        public CartController(PetShopContext context, INotyfService notyfService)
        {
            _context = context;
            _notyfService = notyfService;
        }

        public List<CartItem> Cart
        {
            get
            {
                var cart = HttpContext.Session.Get<List<CartItem>>("Cart");
                if (cart == null)
                {
                    cart = new List<CartItem>();
                }
                return cart;
            }
        }

        // GET: Cart
        public IActionResult Index()
        {
            return View(Cart);
        }

        // POST: Add item to cart
        [HttpPost]
        public IActionResult Add(int productId, int quantity = 1)
        {
            var product = _context.Products.Find(productId);
            if (product == null)
            {
                _notyfService.Error("Sản phẩm không tồn tại!");
                return Json(new { success = false });
            }

            var cart = Cart;
            var existingItem = cart.FirstOrDefault(x => x.Product?.Id == productId);

            if (existingItem != null)
            {
                existingItem.amount += quantity;
            }
            else
            {
                cart.Add(new CartItem
                {
                    Product = product,
                    amount = quantity
                });
            }

            HttpContext.Session.Set<List<CartItem>>("Cart", cart);
            _notyfService.Success("Thêm sản phẩm vào giỏ hàng thành công!");
            
            return Json(new { success = true, cartCount = cart.Sum(x => x.amount) });
        }

        // POST: Update cart item quantity
        [HttpPost]
        public IActionResult Update(int productId, int quantity)
        {
            var cart = Cart;
            var item = cart.FirstOrDefault(x => x.Product?.Id == productId);

            if (item != null)
            {
                if (quantity <= 0)
                {
                    cart.Remove(item);
                }
                else
                {
                    item.amount = quantity;
                }

                HttpContext.Session.Set<List<CartItem>>("Cart", cart);
                _notyfService.Success("Cập nhật giỏ hàng thành công!");
            }

            return Json(new { success = true, cartCount = cart.Sum(x => x.amount) });
        }

        // POST: Remove item from cart
        [HttpPost]
        public IActionResult Remove(int productId)
        {
            var cart = Cart;
            var item = cart.FirstOrDefault(x => x.Product?.Id == productId);

            if (item != null)
            {
                cart.Remove(item);
                HttpContext.Session.Set<List<CartItem>>("Cart", cart);
                _notyfService.Success("Đã xóa sản phẩm khỏi giỏ hàng!");
            }

            return Json(new { success = true, cartCount = cart.Sum(x => x.amount) });
        }

        // POST: Clear entire cart
        [HttpPost]
        public IActionResult Clear()
        {
            HttpContext.Session.Set<List<CartItem>>("Cart", new List<CartItem>());
            _notyfService.Success("Đã xóa tất cả sản phẩm trong giỏ hàng!");
            
            return Json(new { success = true });
        }

        // GET: Get cart count for AJAX
        [HttpGet]
        public IActionResult GetCartCount()
        {
            var cart = Cart;
            return Json(new { count = cart.Sum(x => x.amount) });
        }

        // GET: Get cart items for AJAX
        [HttpGet]
        public IActionResult GetCartItems()
        {
            var cart = Cart;
            var cartData = cart.Select(item => new
            {
                productId = item.Product?.Id,
                productName = item.Product?.Name,
                price = item.Product?.Price,
                quantity = item.amount,
                total = (item.Product?.Price ?? 0) * item.amount
            });

            return Json(new { 
                success = true, 
                items = cartData, 
                totalAmount = cartData.Sum(x => x.total) 
            });
        }
    }
}