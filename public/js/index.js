import { handleInputActions } from "./handler/index.js";
const form = document.querySelector('#form-cidadao')

for (let i = 0; i < form.elements.length; i++) {
    const field = form.elements.item(i);

    if (
        field.name == "data_bi_emissao" ||
        field.name == "data_bi_validade" ||
        field.name == "data_nascimento" ||
        field.name == "sexo" ||
        field.name == "estado_civil" ||
        field.name == "nome_tq" ||
        field.name == "data_n_tq" ||
        field.name == "data_bie_tq" ||
        field.name == "data_biv_tq" ||
        field.name == "data_ck_intl" ||
        field.name == 'data_nac_intl' ||
        field.name == 'data_nascimento_last') {
        field.addEventListener('change', (e) => handleInputActions(form, e.target))
        continue;
    }
    field.addEventListener('keyup', (e) => handleInputActions(form, e.target))
}

