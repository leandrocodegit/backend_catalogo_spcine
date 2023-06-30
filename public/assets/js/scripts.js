
// Sidebar mobile open

function openLeftMenu() {
  document.getElementById("leftMenu").style.display = "flex";
}

function closeLeftMenu() {
  document.getElementById("leftMenu").style.display = "none";
}



// Tooltip css

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

// Validação formulario bootstrap

const forms = document.querySelectorAll('.needs-validation')

Array.from(forms).forEach(form => {
  form.addEventListener('submit', event => {
    if (!form.checkValidity()) {
      event.preventDefault()
      event.stopPropagation()
    }

    form.classList.add('was-validated')
  }, false)
})

function adicionar() {
  var element = document.getElementById('box-descricao');
  element.innerHTML += '<div class="mb-2">' +
  '<label for="nome" class="form-label">Titulo</label>' +
  '<input type="text" class="form-control" id="nome" name="nome" required>' +
  '<div class="invalid-feedback">Nome do catalogo.</div>' +
  '<label for="nome" class="form-label">Descição</label>' +
  '<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>' +
  '<div class="invalid-feedback">Nome do catalogo.</div>' +
'</div>'
}

 

