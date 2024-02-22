/**
 *
 * @param {Function} callback
 * @param {number} delay
 * @returns  void
 * O objectio e melhorar o desempenho da função SetTimeout
 * minimizando as requições feita na API,
 */
export const createDelayDispatch = function (callback, delay) {
    let timeoutId;
    return function () {
        const context = this;
        const args = arguments
        clearInterval(timeoutId)
        timeoutId = setTimeout(function () {
            callback.apply(context, args)
        }, delay)
    }
}
export const generateObjectQuery = function (form) {
    const object = {}
    for (let field of form.elements) {

        if (field.value.trim() != ""){
            // if(field.name == "nacionalidade") console.log(field.value);
            object[field.name] = field.value
        }
    }
    return object
}
