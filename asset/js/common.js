//Default Category 0
// var categoryID    = 0;
// getCategories(categoryID);
function getCategories(categoryID) {
    $.ajax({
        type: 'GET',
        url: '/Cashier/MakeOrder/getCategories/' + categoryID,
        success: function (Response) {
            $('#categoryDiv').html('');
            $('#categoryDiv').append(Response);
            $('.cat-back').val(categoryID);
        }
    });
}

function getSetMenu() {
    $.ajax({
        type: 'GET',
        url: '/Cashier/MakeOrder/getSetMenu',
        success: function (Response) {
            $('#categoryDiv').html('');
            $('#categoryDiv').append(Response);
            $('.cat-back').val(categoryID);
        }
    });
}

function returnBack() {
    window.location     = "/Cashier/MakeOrder";
}

function backBtn() {
    // var cat_back        = $(".cat-back").val();
    $.ajax({
        type: 'GET',
        url: '/Cashier/MakeOrder/backCategory/0',
        success: function (Response) {
            $('#categoryDiv').html('');
            $('#categoryDiv').append(Response);
        }
    });
}

//Function For Order Item
function orderItem(itemID) {
    var take_id        = $('input#take-id').val();
    $.ajax({
        type: 'GET',
        url: '/Cashier/MakeOrder/item/' + itemID + '/' + take_id,
        success: function (Response) {
            $('.item-list > tbody:last-child').append(Response);
            calculateTotal();
        }
    });
}

//Function For Order SetMenu
function orderSetMenu(setMenuID) {
    var take_id        = $('input#take-id').val();
    $.ajax({
        type: 'GET',
        url: '/Cashier/MakeOrder/setMenu/' + setMenuID + '/' + take_id,
        success: function (Response) {
            $('.item-list > tbody:last-child').append(Response);
            calculateTotal();
        }
    });
}

//Function For continent Choose
function continentOK(itemID,uniqid) {
    continentID     = $('#continent-select-' + uniqid).val();
    //Find Continent Price and discount
    textID      = "continent-" + uniqid;
    priceID     = "price-" + uniqid;
    discountID  = "discount-" + uniqid;
    amountID    = "amount-" + uniqid;
    $.ajax({
        type: 'GET',
        url: '/Cashier/MakeOrder/continent/' + itemID + '/' + continentID,
        success: function (Response) {
            console.log(Response);
            price_with_discount     = parseInt(Response.price_with_discount);
            priceval    = parseInt(Response.price);
            // if (isNaN(price_with_discount)) {
            //     priceval    = parseInt(Response.price);
            // } else {
            //     priceval    = price_with_discount;
            // }
            id          = parseInt(Response.id);
            discount    = parseInt(Response.discount_price);
            document.getElementById(textID).textContent = Response.name + " (" + Response.cname + ")";
            document.getElementById(priceID).textContent = priceval;
            extra_price     = parseInt($('#extra-' + itemID + '-' + uniqid).val());
            amount          = (priceval + extra_price) - discount;
            // document.getElementById(priceID).textContent = priceval;
            document.getElementById(discountID).textContent = discount;
            $('input#item-' + uniqid).val(id);
            qty             = $('#qty-' + uniqid);
            currentQty      = parseInt(qty.val());
            changePrice     = calculateItemByQty(currentQty,itemID,uniqid);
            $('input#' + amountID).val(changePrice);
            $('input#price-' + itemID + '-' + uniqid).val(changePrice);
            $('input#amount-without-discount-' + uniqid).val(Response.price);
            calculateTotal();
        }
    });
    $('input#continent-' + itemID + '-' + uniqid).val(continentID);
    // $('.price-' + uniqid).val(continentID);
}

//Function For Add On Checked
function addOnOK(itemID,uniqid) {
    addOnID         = '';
    addOnVal        = 0;
    $('#addon-' + itemID + '-' + uniqid + ' input:checkbox').each(function () {
        if($(this).is(':checked')) {
            addon       = $(this).val();
            addon_array = addon.split(',');
            addOnID    += "," + addon_array[0];
            addOnVal    += parseInt(addon_array[1]);
        }
    });
    $('input#addon-' + itemID + '-' + uniqid).val(addOnID);
    $('input#extra-' + itemID + '-' + uniqid).val(addOnVal);
    //Get quantity
    qty             = $('#qty-' + uniqid);
    currentQty      = parseInt(qty.val());
    changePrice     = calculateItemByQty(currentQty,itemID,uniqid);
    $('input#amount-' + uniqid).val(changePrice);
    $('input#price-' + itemID + '-' + uniqid).val(changePrice);
    calculateTotal();

}
// $(document).ready(function(){
//     //If Send Order Button Click
//     $('#order-item').click(function(){
//         var itemCount   = parseInt($('.item-list tbody tr').length);
//         if (itemCount <= 0) {
//             swal({
//                 title: "Order Unable to send!",
//                 text: "You have to select at least one item.",
//                 type: "info",
//                 showCancelButton: false,
//                 confirmButtonColor: "#86CCEB",
//                 confirmButtonText: "Confirm",
//                 closeOnConfirm: false
//             });
//         } else {
//             $("#order-form").submit();
//         }
//     });
// });
// function quantityPlus(itemID,uniqid) {
//     //Fetch qty in the current elements context and since you have used class selector use it.
//     var qty = $('#qty-' + uniqid);
//     var currentVal = parseInt(qty.val());
//     if (!isNaN(currentVal)) {
//         currentPlus     = parseInt(currentVal + 1);
//         qty.val(currentPlus);
//         //Calculate Amount
//         amount_with_qty     = calculateItemByQty(currentPlus,itemID,uniqid);
//         $('input#price-' + itemID + '-' + uniqid).val(amount_with_qty);
//         $('input#amount-' + uniqid).val(amount_with_qty);
//         calculateTotal();
//     } else {
//         qty.val(1);
//     }
//
//     //Trigger change event
//     qty.trigger('change');
// }
//
// function quantityMinus(itemID,uniqid) {
//     var qty = $('#qty-' + uniqid);
//     var currentVal = parseInt(qty.val());
//     if (!isNaN(currentVal)) {
//         if (currentVal == 1) {
//             qty.val(1);
//             changePrice       = calculateItemByQty(1,itemID,uniqid);
//             $('input#price-' + itemID + '-' + uniqid).val(changePrice);
//             $('input#amount-' + uniqid).val(changePrice);
//             calculateTotal();
//         } else {
//             currentChange     = parseInt(currentVal - 1);
//             qty.val(currentChange);
//             changePrice       = calculateItemByQty(currentChange,itemID,uniqid);
//             $('input#price-' + itemID + '-' + uniqid).val(changePrice);
//             $('input#amount-' + uniqid).val(changePrice);
//             calculateTotal();
//         }
//     } else {
//         qty.val(1);
//     }
//
//     //Trigger change event
//     qty.trigger('change');
// }

// function CancelItem(uniqid,detailID) {
//     $('#item-tr-' + uniqid).remove();
//     calculateTotal();
// }

function calculateItemByQty(qty,itemID,uniqid) {
    priceOrigin     = $('#price-' + uniqid).text();
    priceOrigin     = parseInt(priceOrigin);

    discountOrigin  = parseInt($('#discount-' + uniqid).text());
    if (isNaN(discountOrigin)) {
        discountOrigin  = 0;
    }

    extraOrigin     = parseInt($('input#extra-' + itemID + '-' + uniqid).val());
    if (isNaN(extraOrigin)) {
        extraOrigin  = 0;
    }

    amount_without_qty = (priceOrigin + extraOrigin) - discountOrigin;
    amount_with_qty    = amount_without_qty * qty;
    return amount_with_qty;
}

function calculateTotal() {
    //Calculate For Price
    var price_arr   = $('input[name="price[]"]').map(function () {
        return this.value; // $(this).val()
    }).get();

    var priceTotal  = 0;
    for (key in price_arr) {
        priceTotal      += parseInt(price_arr[key]);
    }
    $('input.price_total').val(priceTotal);
    document.getElementById('sub-total').textContent = priceTotal;

    //Calculate Tax
    var tax         = parseInt($('input.tax').val());
    var service     = parseInt($('input.service').val());
    var room        = parseInt($('input#room-amount').val());
    if (isNaN(tax)) {
        tax         = 0;
    }
    if (isNaN(service)) {
        service         = 0;
    }
    if (isNaN(room)) {
        room         = 0;
    }
    tax_amount       = (priceTotal * tax)/100;
    service_amount   = (priceTotal * service)/100;
    net_amount       = priceTotal + tax_amount + service_amount + room;
    document.getElementById('sub-gst').textContent          = tax_amount;
    document.getElementById('sub-service').textContent      = service_amount;
    document.getElementById('sub-room').textContent         = room;
    document.getElementById('price-total').textContent      = net_amount;
    $('input#service-amount').val(service_amount);
    $('input#tax-amount').val(tax_amount);
    $('input#price_total').val(net_amount);
}