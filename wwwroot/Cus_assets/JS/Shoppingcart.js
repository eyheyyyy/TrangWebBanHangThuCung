$(document).ready(function () {
    
    $(".addproduct").on("click", function (e) {
        //input_quantity_product
        
        e.preventDefault();
        var id = $(this).data("id");

        var quantity = 1;
        var tQuantity = $(".input_quantity_product").val();

        if (!isNaN(tQuantity) && tQuantity != '') {
            quantity = parseInt(tQuantity);
        }
        //#region Lấy đường dẫn controller và action
        /*var currentUrl = window.location.href;

        // Tách URL thành các phần như protocol, host, path, và query
        var urlParts = currentUrl.split('?');
        var baseUrl = urlParts[0];
        var query = urlParts.length > 1 ? '?' + urlParts[1] : '';

        // Tách đường dẫn (path) thành các phần riêng lẻ
        var pathParts = baseUrl.split('/');
        var controller = pathParts[3]|| "home"; // Controller nằm ở vị trí thứ 3 trong đường dẫn
        var action = pathParts[4]||"index";     // Action nằm ở vị trí thứ 4 trong đường dẫn
        //#endregion
        
        var address = `/${controller}/${action}/?message=${message}&type=${type}`;*/
        //alert(controller +" "+action)
        $.ajax({
            url: "/ShoppingCart/AddToCart",
            type: "POST",
            dataType: "json",
            data: { productID: id, amount: quantity },
            success: function (data) {
                //alert(data);
                if (data.success) {
                    
                    
                    Toastify({

                        text: "Bạn vừa đặt thành công sản phẩm",
                        close: true,
                        duration: 2000,
                        style: {
                            background: "#28a745",
                        }, 
                        offset: {
                            x: 0, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 70 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        }

                    }).showToast();
                    setTimeout(function () {
                        location.reload();
                    }, 3000); 
                    
                }
                else 
                {
                    location.reload();
                }
                
            }
        });


    });
})
