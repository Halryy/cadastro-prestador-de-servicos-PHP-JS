function adicionaClasseBotoes() {
  document.querySelectorAll(".delete-btn").forEach((button, index) => {
    if (!button.classList.contains(`delete-btn-${index}`)) {
      button.classList.add(`delete-btn-${index}`);
    }
  })
}

document.querySelectorAll(".excluir-td").forEach((td, index) => {
  td.classList.add(`excluir-td-${index}`);
})

function identificaFormulario() {
  document.querySelectorAll(".formDeletaPrestador").forEach((form, index) => {
    if (!form.classList.contains(`formDeletaPrestador${index}`)) {
      form.classList.add(`formDeletaPrestador${index}`);
    }
  })
}

function adicionaEventoBotoesDelete() {
  const deleteBtns = document.querySelectorAll(".delete-btn");
  deleteBtns.forEach((button, index) => {
    button.addEventListener("click",  (event) => {
      event.preventDefault();
      trocaBotoes(index);
    })
  })
}

function trocaBotoes(index) {
  document.querySelector(`.excluir-td-${index}`).innerHTML = 
  `
  <div id='div-${index}'>
    <i id='confirmar-btn-${index}' class="btn-acoes fas fa-check"></i>
    <i id='cancelar-btn-${index}' class="btn-acoes fas fa-times"></i>
  </div>
  `
  document.querySelector(`#div-${index}`).style = "display: flex; gap: 48%;";
  const btnConfirmar = document.querySelector(`#confirmar-btn-${index}`);
  const btnCancelar = document.querySelector(`#cancelar-btn-${index}`);
  
  btnConfirmar.style = "color: #00ff1e;";
  btnCancelar.style = "color: #ff0000;";

  btnConfirmar.addEventListener("click", () => {
    document.querySelector(`.formDeletaPrestador${index}`).submit();
  })
  btnCancelar.addEventListener("click", () => {
    // location.reload();
    // btnConfirmar.style = "display: none;";
    // btnCancelar.style = "display: none;";
    // document.querySelector(`.delete-btn-${index}`).style.visibility = 'visible';
    document.querySelector(`.excluir-td-${index}`).innerHTML = '<button class="delete-btn"><i class="far fa-trash-alt"></i></button>';
    adicionaEventoBotoesDelete();
  })
}

document.querySelector("#btnAjuda").addEventListener("click", () => {
  window.open("https://www.youtube.com/watch?v=7caT5jhPcLc", "_blank");
});

adicionaClasseBotoes();
identificaFormulario();
adicionaEventoBotoesDelete();