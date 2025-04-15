const modal = document.getElementById('modal');
const formAddInvoice = document.getElementById('add-invoice');

function openAddInvoice () {
    modal.classList.add('open-modal');
    formAddInvoice.classList.add('open-add-invoice');
    document.querySelector(".hidden-log-out").classList.add("active");
}

function closeAddInvoice () {
    modal.classList.remove('open-modal');
    formAddInvoice.classList.remove('open-add-invoice');
    document.querySelector(".hidden-log-out").classList.remove("active");
}