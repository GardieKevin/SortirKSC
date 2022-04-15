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

    let name = document.getElementById('name');
    let campus = document.getElementById('campus');
    let eventsSearched = [];

    fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results => {

        //mise à blanc de la liste des events
        $(event).html("")

        for (let result of results) {

            if (result['name'].toLowerCase().includes(name.value.toLowerCase())) {
                eventsSearched.push(result);
            }

            if (result['campus']['name'].includes(campus.value)){
                eventsSearched.includes(result['id']);
            }
        }

        for(let event of eventsSearched){
            $('#event').append('<h2>' + "Name : " + event['name'] + '</h2>',
                '<div>' + "Date & Hour : " + event['startingDate'] + '</div>',
                '<div>' + "Duration : " + event['duration'] + '</div>',
                '<div>' + "Inscription limit : " + event['limitInscribeDate'] + '</div>',
                '<div>' + "Max affluence : " + event['maxInscriptionsNumber'] + '</div>',
                '<div>' + "Informations : " + event['informations'] + '</div>',
                '<a href="user/' + event['organisator']['id'] + '">' + event['organisator']['pseudo'] + '</a>',
                '<div>' + "Campus : " + event['campus']['name'] + '</div>',
                '<a href="event/detail/' + event['id'] + '"><button type="submit"> Détails </button></a>',)
        }
    })
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