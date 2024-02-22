export const fetchQueryAPI = function (body) {

    fetch('/api/cidadao', {
        method: "POST",
        headers: { 'Content-Type': "application/json" },
        body: JSON.stringify(body)
    })
        .then(res => res.json())
        .then(data => console.log("A resposta chegou :", data))
}
