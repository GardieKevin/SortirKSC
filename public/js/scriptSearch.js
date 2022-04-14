let event = $('#event');
let apiUrl = 'http://127.0.0.1:8000/api/events.json';

function loading(){
    fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results => {
        for (let result of results){
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

function maMethode() {
    let campus = document.getElementById('campus');
    let name = document.getElementById('name');

    let dateStart = document.getElementById('dateStart').valueAsDate;
    console.log(dateStart);
    let dateEnd = document.getElementById('dateEnd').valueAsDate;
    console.log(dateEnd);

    if (dateStart === null){
        dateStart = Date.now();
        console.log(dateStart);
    }

    console.log(dateStart);
    if(dateEnd === null){
        dateEnd = Date.now()+ 86400 * 1000 * 365;
        console.log(dateEnd);
    }
    console.log(dateEnd);

    fetch(apiUrl, {method: 'get'}).then(response => response.json()).then(results => {

    //mise à blanc de la liste des events
    $(event).html("")
    for (let result of results) {

        let date = new Date(result['startingDate']).getTime();

        if(result['name'].toLowerCase().includes(name.value.toLowerCase()) &&
                result['campus']['name'].includes(campus.value) &&
                date > dateStart && date < dateEnd){

                //Construction de l'event
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
        }
    })
}