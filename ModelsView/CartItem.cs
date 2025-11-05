
using Pet_Shop2.Models;

namespace Pet_Shop2.ModelsView
{
    public class CartItem
    {
        public Product? Product { get; set; }
        public int amount { get; set; }
        public double TotalMoney => amount * (Product.Price.HasValue ? (double)Product.Price : 0.0);
    }
}
