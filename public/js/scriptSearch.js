let event = $('#event');
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
    let idUser = 1;
    console.log(idUser);
    if(document.getElementById("organisator").checked === true){
        idUser = parseInt(document.getElementById('idUser').value);
    }
    console.log(idUser);

    let idParticipant = 0;
    console.log(idParticipant);
    if (document.getElementById("participant").checked === true){
        idParticipant = parseInt(document.getElementById('idUser').value);
    }
    console.log(idParticipant);


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

    fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results => {

        //mise à blanc de la liste des events
        $(event).html("")

        for (let result of results) {
            let date = new Date(result['startingDate']).getTime();

            if (result['name'].toLowerCase().includes(name.value.toLowerCase()) &&
                result['campus']['name'].includes(campus.value) &&
                date > dateStart && date < dateEnd){
                eventSearched.push(result);
            }
        }
    })
    console.log(eventSearched);

    let resultat = eventSearched.filter(event => event.organisator.id === idReceived);
    console.log(resultat);

}


//
// function myMethod() {
//     let campus = document.getElementById('campus');
//     let name = document.getElementById('name');
//     let dateStart = document.getElementById('dateStart').valueAsDate;
//     let dateEnd = document.getElementById('dateEnd').valueAsDate;
//
//     if (dateStart === null){
//         dateStart = Date.now();
//     }
//     if(dateEnd === null){
//         dateEnd = Date.now()+ 86400 * 1000 * 365;
//     }
//
//     let idReceived
//     if (document.getElementById("organisator").checked === true){
//         idReceived = document.getElementById("organisator").value
//     } else{
//         idReceived = false
//     }
//     console.log(idReceived);
//
//     fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results => {
//
//     //mise à blanc de la liste des events
//     $(event).html("")
//     for (let result of results) {
//         console.log(result['organisator']['id'])
//         let date = new Date(result['startingDate']).getTime();
//
//         if(result['name'].toLowerCase().includes(name.value.toLowerCase()) &&
//             result['campus']['name'].includes(campus.value) &&
//             date > dateStart && date < dateEnd &&
//             idReceived){
//
//                 //Construction de l'event
//                 $(event).append('<h2>' + "Name : " + result['name'] + '</h2>',
//                     '<div>' + "Date & Hour : " + result['startingDate'] + '</div>',
//                     '<div>' + "Duration : " + result['duration'] + '</div>',
//                     '<div>' + "Inscription limit : " + result['limitInscribeDate'] + '</div>',
//                     '<div>' + "Max affluence : " + result['maxInscriptionsNumber'] + '</div>',
//                     '<div>' + "Informations : " + result['informations'] + '</div>',
//                     '<a href="user/' + result['organisator']['id'] + '">' + result['organisator']['pseudo'] + '</a>',
//                     '<div>' + "Campus : " + result['campus']['name'] + '</div>',
//                     '<a href="event/detail/' + result['id'] + '"><button type="submit"> Détails </button></a>',
//                 )
//             }
//         }
//     })
// }