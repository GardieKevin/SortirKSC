function maMethode() {
    let name = document.getElementById('name');
    let event = $('#event');

    let apiUrl = 'http://127.0.0.1:8000/api/events.json';

    fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results => {
            if (results.length) {
                $(event).html("")
                for (let result of results) {
                    if (name.value === "") {
                        let variable = result['name'];
                        let informations = result['informations'];
                        $(event).append('<div>' + "Name : " + variable + '</div>',
                                        '<div>' + "Informations : " + informations + '</div>')
                    } else {
                        if (result['name'] === name.value) {
                            let variable = result['name'];
                            let informations = result['informations'];
                            let id = result['organisator']['id'];
                            //let organisator = result['organisator']['pseudo'];
                            $(event).append('<div>' + variable +'</div>',
                                            '<div>' + informations + '</div>',
                                            '<a href="user/'+id+'">' + result['organisator']['pseudo'] + '</a>')
                        }
                    }
                }
            }
        }
    )
}