function updateOrderStatus(target, orderId) {
    var status = target.value;
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var ajax_url = "order/update_order_status/" + orderId + "/" + status;
    $.ajax({
        type: "GET",
        url: ajax_url,
        success: function (data) {
            if (data.order_mess.includes("Error")) {
                Swal.fire({
                    title: "Oops...",
                    text: data.order_mess,
                    icon: "error",
                    customClass: "swal-wide",
                });
            } else {
                window.location.reload();
            }
        },
        error: function () {
            console.log("Something went wrong");
        },
    });
}

var del_order_btns = document.getElementsByName("delete_order_btn");

del_order_btns.forEach((element) => {
    element.addEventListener("click", function (event) {
        event.preventDefault();
        orderId = parseInt(this.getAttribute("id"));
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            customClass: "swal-wide",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                var ajaxUrl = "order/delete_order/" + orderId;
                $.ajax({
                    type: "POST",
                    url: ajaxUrl,
                    success: function (data) {
                        if (data.order_mess.includes("Error")) {
                            Swal.fire({
                                title: "Oops...",
                                text: data.order_mess,
                                icon: "error",
                                customClass: "swal-wide",
                            });
                        } else {
                            window.location.reload();
                        }
                    },
                    error: function () {
                        console.log("Something went wrong");
                    },
                });
            }
        });
    });
});
