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
                        let startingDate = result['startingDate'];
                        let duration = result['duration'];
                        let limit = result['limitInscribeDate'];
                        let affluence = result['maxInscriptionsNumber'];
                        let id = result['organisator']['id'];
                        let campus = result['campus']['name'];
                        $(event).append('<h2>' + "Name : " + variable + '</h2>',
                                        '<div>' + "Date & Hour : " + startingDate + '</div>',
                                        '<div>' + "Duration : " + duration + '</div>',
                                        '<div>' + "Inscription limit : " + limit + '</div>',
                                        '<div>' + "Max affluence : " + affluence + '</div>',
                                        '<div>' + "Informations : " + informations + '</div>',
                                        '<a href="user/'+id+'">' + result['organisator']['pseudo'] + '</a>',
                                        '<div>' + "Campus : " + campus + '</div>',)

                    } else {
                        if (result['name'] === name.value) {
                            let variable = result['name'];
                            let informations = result['informations'];
                            let startingDate = result['startingDate'];
                            let duration = result['duration'];
                            let limit = result['limitInscribeDate'];
                            let affluence = result['maxInscriptionsNumber'];
                            let id = result['organisator']['id'];
                            let campus = result['campus']['name'];
                            $(event).append('<h2>' + "Name : " + variable + '</h2>',
                                '<div>' + "Date & Hour : " + startingDate + '</div>',
                                '<div>' + "Duration : " + duration + '</div>',
                                '<div>' + "Inscription limit : " + limit + '</div>',
                                '<div>' + "Max affluence : " + affluence + '</div>',
                                '<div>' + "Informations : " + informations + '</div>',
                                '<a href="user/'+id+'">' + result['organisator']['pseudo'] + '</a>',
                                '<div>' + "Campus : " + campus + '</div>',)
                        }
                    }
                }
            }
        }
    )
}