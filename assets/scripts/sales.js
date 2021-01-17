import $ from "jquery";
// import {  } from "bootstrap";

console.log("SALESJS says HI");

var $collectionHolder;
var $addTransactionButton = $('<button type="button" class="add_transaction_link btn btn-block btn-info my-3">Add Items Transaction</button>');
var $newLinkLi = $('<div class="col"></div>').append($addTransactionButton);

$(function() {
    $collectionHolder = $('#sale_transactions');
    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $addTransactionButton.on('click', function(e) {
        addTransactionForm($collectionHolder, $newLinkLi);
    });
});

function addTransactionForm($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);
    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div class="col-12"></div>').append(newForm);
    $newLinkLi.before($newFormLi);
    var $price = 0;
    var $selitem = '';
    $('#sale_transactions_'+index+'_saleitem').on('change',(e)=>{
        $selitem = e.currentTarget['value'];
    });
    $('#sale_transactions_'+index+'_quantity').on('keyup',(e)=>{
        var $quantity = e.currentTarget.value;
        getItemPrice('/salesapi?item='+$selitem, $quantity);
    });
}

function getItemPrice(url, qty) {
    var $price = $.getJSON(url);
    priceText = $('#price').text();
    $price.done((d)=>{
        priceText === '' ? priceText = 0 : priceText = parseFloat(priceText);
        priceText = priceText + d.price*parseFloat(qty)/100;
        $('#price').text(priceText);
    });
}

