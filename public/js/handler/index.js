import { fetchQueryAPI } from "../services/api.js"
import { createDelayDispatch, generateObjectQuery } from "../utils/index.js"

/**
 * @[pesquisaLizy] injeta parametros na function [fetchQueryAPI]
 *
 */
const dispatchRequestApi = createDelayDispatch(fetchQueryAPI, 1000)

/**
 * @[handleInputActions]
 * disparar e injectar o objecto de pesquisa no [fetchQueryAPI]
*/

export const handleInputActions = function (form/**Formulario */, target) {

    if (target.name == "data_ck_intl") target.value = target.checked ? "ON" : "OFF";
    if (target.name == "data_nac_intl") target.value = target.checked  ? "ON" : "OFF";

    const bodyQuery = generateObjectQuery(form)
    console.log(bodyQuery)
    dispatchRequestApi(bodyQuery)
}
