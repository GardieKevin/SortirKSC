function maMethode() {
    let name = document.getElementById('name');
    let event = $('#event');

    let apiUrl = 'http://127.0.0.1:8000/api/events.json';

    fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results => {
            if (results.length) {

                //mise à blanc de la liste des évents
                $(event).html("")
                for (let result of results) {

                    //Si le champ de saisie est vide on affiche tous les évènements
                    if (name.value === "") {
                        let variable = result['name'];
                        let informations = result['informations'];
                        let startingDate = result['startingDate'];
                        let duration = result['duration'];
                        let limit = result['limitInscribeDate'];
                        let affluence = result['maxInscriptionsNumber'];
                        let id = result['organisator']['id'];
                        let campus = result['campus']['name'];
                        let idEvent = result['id'];

                        //Construction de l'évent
                        $(event).append('<h2>' + "Name : " + variable + '</h2>',
                            '<div>' + "Date & Hour : " + startingDate + '</div>',
                            '<div>' + "Duration : " + duration + '</div>',
                            '<div>' + "Inscription limit : " + limit + '</div>',
                            '<div>' + "Max affluence : " + affluence + '</div>',
                            '<div>' + "Informations : " + informations + '</div>',
                            '<a href="user/' + id + '">' + result['organisator']['pseudo'] + '</a>',
                            '<div>' + "Campus : " + campus + '</div>',
                            '<a href="event/detail/' + idEvent + '"><button type="submit"> Détails </button></a>',
                        )

                    } else {

                        //Si le champ de saisie contient EXACTEMENT la chaine de caractère, alors ca affiche l'évent
                        if (result['name'] === name.value) {
                            let variable = result['name'];
                            let informations = result['informations'];
                            let startingDate = result['startingDate'];
                            let duration = result['duration'];
                            let limit = result['limitInscribeDate'];
                            let affluence = result['maxInscriptionsNumber'];
                            let id = result['organisator']['id'];
                            let campus = result['campus']['name'];

                            //Construction de l'évent
                            $(event).append('<h2>' + "Name : " + variable + '</h2>',
                                '<div>' + "Date & Hour : " + startingDate + '</div>',
                                '<div>' + "Duration : " + duration + '</div>',
                                '<div>' + "Inscription limit : " + limit + '</div>',
                                '<div>' + "Max affluence : " + affluence + '</div>',
                                '<div>' + "Informations : " + informations + '</div>',
                                '<a href="user/' + id + '">' + result['organisator']['pseudo'] + '</a>',
                                '<div>' + "Campus : " + campus + '</div>',
                                '<a href="event/detail/' + idEvent + '"><button type="submit"> Détails </button></a>',
                            )
                        }
                    }
                }
            }
        }
    )
}