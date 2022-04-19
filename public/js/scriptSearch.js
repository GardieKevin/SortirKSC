let div = $('#event');
let apiUrl = 'http://127.0.0.1:8000/api/events.json';

function display() {
    fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results => {
        for (let result of results) {
            $(event).append('<h2>' + "Name : " + result['name'] + '</h2>',
                '<div>' + "Date & Hour : " + result['startingDate'] + '</div>',
                '<div>' + "Duration : " + result['duration'] + '</div>',
                '<div>' + "Inscription limit : " + result['limitInscribeDate'] + '</div>',
                '<div>' + "Max affluence : " + result['maxInscriptionsNumber'] + '</div>',
                '<div>' + "Informations : " + result['informations'] + '</div>',
                '<a href="user/' + result['organisator']['id'] + '">' + result['organisator']['pseudo'] + '</a>',
                '<div>' + "Campus : " + result['campus']['name'] + '</div>',
                '<a href="event/detail/' + result['id'] + '"><button type="submit"> Détails </button></a>',
            )
        }
    })
}

function myMethod() {

    fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results =>{

        let eventsTaken = [];
        let idUser;
        if(document.getElementById("organisator").checked === true){
            idUser = parseInt(document.getElementById('idUser').value);
            for (let result of results){
                if (idUser === result.organisator.id){
                    console.log('je prends cet event')
                    eventsTaken.push(result);
                }
            }
        } else{
            for (let result of results){
                console.log("Je prends cet event comme tous les autres");
                eventsTaken.push(result);
            }
        }
        console.log(eventsTaken);

        let campus = document.getElementById('campus');
        let name = document.getElementById('name');
        let dateStart = document.getElementById('dateStart').valueAsDate;
        let dateEnd = document.getElementById('dateEnd').valueAsDate;

        let eventSearched = [];

        if (dateStart === null) {
            dateStart = Date.now();
        }
        if (dateEnd === null) {
            dateEnd = Date.now() + 86400 * 1000 * 365;
        }

        for (let event of eventsTaken) {
            let date = new Date(event['startingDate']).getTime();

            if (event['name'].toLowerCase().includes(name.value.toLowerCase())
                && event['campus']['name'].includes(campus.value)
                && (date > dateStart && date < dateEnd)
            ){
                eventSearched.push(event);
            }
        }
        console.log(eventSearched);

        $(div).html("")

        for (let event of eventSearched){

            //Construction de l'event
            div.append('<h2>' + "Name : " + event['name'] + '</h2>',
                '<div>' + "Date & Hour : " + event['startingDate'] + '</div>',
                '<div>' + "Duration : " + event['duration'] + '</div>',
                '<div>' + "Inscription limit : " + event['limitInscribeDate'] + '</div>',
                '<div>' + "Max affluence : " + event['maxInscriptionsNumber'] + '</div>',
                '<div>' + "Informations : " + event['informations'] + '</div>',
                '<a href="user/' + event['organisator']['id'] + '">' + event['organisator']['pseudo'] + '</a>',
                '<div>' + "Campus : " + event['campus']['name'] + '</div>',
                '<a href="event/detail/' + event['id'] + '"><button type="submit"> Détails </button></a>')
        }



    })
}

//TODO vérifier le fonctionnement des dates (bizarre) et faire l'affichage de la liste
//TODO ajouter le critère de recherche sur les events auxquels je participe ou non
//let idParticipant;
//if (document.getElementById("participant").checked === true){
//    idParticipant = parseInt(document.getElementById('idUser').value);
//}
//console.log(idParticipant);