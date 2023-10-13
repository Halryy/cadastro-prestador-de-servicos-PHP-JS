document.querySelector("#formulario").addEventListener("submit", verificador);
const formulario = document.querySelector("#formulario");
const nome = document.querySelector("#nome");
const sobrenome = document.querySelector("#sobrenome");
const email = document.querySelector("#email");
const website = document.querySelector("#website");
const regiao = document.querySelector("input[name='regiao']:checked");
const periodo = document.querySelector("#periodo");
const dataAtual = new Date();
const atividade = document.querySelector("input[name='atividade']:checked");
const programador = document.querySelector("#programador");
const dba = document.querySelector("#dba");
const fieldsetAcoes = document.querySelector(".acoes");
const fieldsetAtividade = document.querySelector("#fieldset-atividade");
const fieldsetRegiao = document.querySelector("#fieldset-regiao");
const botoes = document.querySelectorAll(".liberar");
const regioes = document.querySelectorAll(".regioes");
const checkboxes = document.querySelectorAll("input[type='checkbox']");
let quantidadeMarcadosCheckbox = [];
let quantidadeMarcadaRegiao = [];
let iniciador = false;

function verificador(event) {
    event.preventDefault();
    iniciador = true;
    if (iniciador === true) {
        formulario.addEventListener("keyup", verificadorAposSubmit);
        formulario.addEventListener("change", verificadorAposSubmit);
        formulario.addEventListener("reset", verificadorAposSubmit);
    }
    let existeNome = verificaNome();
    let existeSobrenome = verificaSobrenome();
    let existeEmailValido = verificaEmail();
    let websiteValido = verificaWebsite();
    let existeUmaRegiaoMarcada = verificaRegiao();
    let datasValidas = verificaDatas();
    let existeUmaCheckboxMarcada = verificaAtividades();
    if (existeNome == false) {
        return false;
    }
    if (existeSobrenome == false) {
        return false;
    }
    if (existeEmailValido == false) {
        return false;
    }
    if (websiteValido == false) {
        return false;
    }
    if (datasValidas == false) {
        return false;
    }
    if (existeUmaCheckboxMarcada == false) {
        return false;
    }
    if (existeUmaRegiaoMarcada == false) {
        return false;
    }
    
    const dataIni = document.querySelector("#dataini");
    const dataFim = document.querySelector("#datafim");

    const prestadorServico = {
        nome: nome.value,
        sobrenome: sobrenome.value,
        email: email.value,
        site: website.value,
        dataInicial: dataIni.value,
        dataFinal: dataFim.value,
        regiao: document.querySelector("input[name=regiao]:checked").value,
        atividadesPretendidas: Array.from(document.querySelectorAll("input[name=atividade]:checked")).map((a) => a.value),
    };

    console.log(prestadorServico);
    this.submit();
    return true;
}

function verificadorAposSubmit() {
    verificaNome();
    verificaSobrenome();
    verificaEmail();
    verificaWebsite();
    verificaDatas();
    verificaAtividades();
    verificaRegiao();
}

function verificaNome() {
    if (nome.value.length < 3) {
        nome.style = "border: 3px solid red";
        nome.setAttribute("placeholder", "Campo obrigatorio.");
        return false;
    }
    nome.style = "border: 1px solid #8a8a8a";
    return true;
}

function verificaSobrenome() {
    if (sobrenome.value.length < 1) {
        sobrenome.style = "border: 3px solid red";
        sobrenome.setAttribute("placeholder", "Campo obrigatorio.");
        return false;
    }
    sobrenome.style = "border: 1px solid #8a8a8a";
    return true;
}

function verificaEmail() {
    const regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (regex.test(email.value)) {
      email.style = "border: 1px solid #8a8a8a";
      return true;
    }
    email.style = "border: 3px solid red";
    email.setAttribute("placeholder", "Campo obrigatorio.");
    return false;
}

function verificaWebsite() {
    const regex = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/;
    if (regex.test(website.value)) {
        website.style = "border: 1px solid #8a8a8a";
        existeWebsiteValido = true;
    } else {
        website.style = "border: 3px solid red";
        existeWebsiteValido = false;
    }
    if (website.value.length === 0) {
        website.style = "border: 1px solid #8a8a8a";
    }
}

function verificaDatas() {
    let erroDataIni = verificaDataIni();
    let erroDataFim = verificaDataFim();
    if (erroDataFim == true || erroDataIni == true) {
        periodo.style = "border: 3px solid red";
        return false;
    }
    return true;
}

function verificaDataIni() {
    const dataIni = document.querySelector("#dataini");
    const dataIniObj = new Date(dataIni.value);
    dataIniObj.setDate(dataIniObj.getDate() + 1);
    const erro = document.querySelector("#erroPeriodoDataIni");
    if (dataIniObj < dataAtual.setHours(21, 0, 0, 0)) {
        dataIniMaiorOuIgualAAtual = false;
        erro.innerHTML = "Data inicial nao pode ser menor que a atual!";
        erro.style = "display: block;";
        dataIni.style = "border: 3px solid red";
        periodo.style = "border: 3px solid red";
        
        return true;
    } else if (isNaN(dataIniObj)) {
        dataIniMaiorOuIgualAAtual = false;
        erro.textContent = "Campo obrigatorio!";
        erro.style = "display: block;";
        dataIni.style = "border: 3px solid red";
        periodo.style = "border: 3px solid red";
        
        return true;
    } 
    erro.textContent = '';
    erro.style = "display: none;";
    dataIniMaiorOuIgualAAtual = true;
    dataIni.style = "border: 1px solid #8a8a8a";
    periodo.style = "border: 1px solid #374956";
        
    return false;
}

function verificaDataFim() {
    const dataFim = document.querySelector("#datafim");
    const dataFimObj = new Date(dataFim.value);
    dataFimObj.setDate(dataFimObj.getDate() + 1);
    const dataIni = document.querySelector("#dataini");
    const dataIniObj = new Date(dataIni.value);
    dataIniObj.setDate(dataIniObj.getDate() + 1);
    const erro = document.querySelector("#erroPeriodoDataFim");
    if (dataFimObj > dataIniObj) {
        dataFimMaiorQueDataIni = true;
        erro.textContent = '';
        erro.style = "display: none;";
        dataFim.style = "border: 1px solid #8a8a8a";
        periodo.style = "border: 3px solid #8a8a8a";

        return false;
    } else if (dataFimObj <= dataIniObj) {
        dataFimMaiorQueDataIni = false;
        erro.textContent = "Data final tem que ser maior que a data inicial!";
        erro.style = "display: block; color: orange;";
        dataFim.style = "border: 3px solid orange";
        periodo.style = "border: 3px solid red";

        return true;
    }
    
    dataFimMaiorQueDataIni = false;
    erro.textContent = "Campo obrigatório!";
    erro.style = "display: block; color: orange;";
    dataFim.style = "border: 3px solid orange";
    periodo.style = "border: 3px solid red";
    
    return true;
}

function verificaAtividades() {
    const erro = document.querySelector("#erroAtividades");
    if (quantidadeMarcadosCheckbox.length === 0) {
        fieldsetAtividade.style = "border: 3px solid red";
        erro.textContent = 'Campo obrigatorio.';
        erro.style = "display: block;";
        return false;
    }
    erro.style = "display: none;";
    fieldsetAtividade.style = "border: 1px solid #8a8a8a";
    return true;
}

function verificaRegiao() {
    const erro = document.querySelector("#erroRegiao");
    if (quantidadeMarcadaRegiao.length == 0) {
        fieldsetRegiao.style = "border: 3px solid red";
        erro.style = "display: block;";
        erro.textContent = "Campo obrigatorio.";
        return false;
    }
    erro.style = "display: none;";
    erro.textContent = "";
    fieldsetRegiao.style = "border: 1px solid #8a8a8a";
    return true;
}

botoes.forEach((botao) => {
    botao.addEventListener("click", () => {
      programador.disabled = false;
      dba.disabled = false;
    });
});

document.querySelector("#centro").addEventListener("click", () => {
    programador.disabled = true;
    dba.disabled = true;
    dba.checked = false;
    programador.checked = false;
    if (quantidadeMarcadosCheckbox.indexOf("DBA") != -1) {
        quantidadeMarcadosCheckbox.splice(quantidadeMarcadosCheckbox.indexOf("DBA"), 1);
    }
    if (quantidadeMarcadosCheckbox.indexOf("Programador") != -1) {
        quantidadeMarcadosCheckbox.splice(quantidadeMarcadosCheckbox.indexOf("Programador"), 1);
    }
});

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("click", (event) => {
        if (quantidadeMarcadosCheckbox.length == 3 && checkbox.checked) {
        event.preventDefault();
        return;
        }
        if (checkbox.checked == true) {
        quantidadeMarcadosCheckbox.push(checkbox.value);
        } else {
        quantidadeMarcadosCheckbox.pop();
        }
    });
});

regioes.forEach((regiao) => {
    regiao.addEventListener("click", () => {
        if (regiao.checked == true) {
            quantidadeMarcadaRegiao.shift();
            quantidadeMarcadaRegiao.push(regiao.value);
        }
    });
});

document.querySelector("#btnReset").addEventListener("click", () => {
    programador.disabled = false;
    dba.disabled = false;
    quantidadeMarcadaRegiao.shift();
});