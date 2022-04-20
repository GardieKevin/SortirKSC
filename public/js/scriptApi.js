$(document).ready(function () {
    let apiUrl = 'https://geo.api.gouv.fr/communes?codePostal=';

    const formatPostcode = '&format=json' + '&boost=population&limit=5';

    let searchPostCode = $('#searchPostCode');
    let postcode = $('#postcode')
    let errorMessage = $('error-message');

    /*Recherche de la commune avec autocompletion */

    $(searchPostCode).on('keyup', function () {

        let code = document.getElementById('searchPostCode').value;

        let url = apiUrl + code + formatPostcode;

        fetch(url, {method: 'get'}).then(response => response.json()).then(results => {
            //console.log(results);
            $(postcode).find('option').remove();
            if (results.length) {
                $.each(results, function (key, value) {
                    //console.log(value);
                    //console.log(value.nom);
                    $(postcode).append('<option value="' + value.nom+ '" id="' + value.nom + '">' + value.nom +'</option>');

                });
            } else {
                if ($(postcode).val()) {
                    console.log('Erreur de code postal.');
                    $(errorMessage).text('Aucune commune avec ce code postal.').show();
                } else {
                    $(errorMessage).text('').hide()
                }
            }
        }).catch(err => {
            console.log(err);
            $(postcode).find('select').remove();
        });
    });

    let apiUrlStreet = 'https://api-adresse.data.gouv.fr/search/?q=';
    const formatStreet = '&format=json';

    let searchStreet = $('#searchStreet');
    let street = $('#street');


    $(searchStreet).on('blur', function (){
        let codeStreet = document.getElementById('searchStreet').value;
        let codePostCode = document.getElementById('searchPostCode').value;
        let url = apiUrlStreet + codeStreet + '&postcode='+ codePostCode +formatStreet;


        fetch(url, {method: 'get'}).then(response => response.json()).then(results => {

            $(street).find('option').remove();
            if (results) {

                results.features.forEach((features)=>{
                    console.log(features.label)
                        $(street).append('<option value="' + features.properties.name + '" id="' + features.properties.name + '">' + features.properties.name +'</option>');

                })
            } else {
                if ($(street).val()) {
                    console.log('Erreur de code postal.');
                    $(errorMessage).text('Aucune commune avec ce code postal.').show();
                } else {
                    $(errorMessage).text('').hide()
                }
            }
        }).catch(err => {
            console.log(err);
            $(postcode).find('select').remove();
        });

    })






});