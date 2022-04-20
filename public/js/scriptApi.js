let coordonneesX = null;
let coordonneesY = null;
$(document).ready(function () {
    let apiUrl = 'https://geo.api.gouv.fr/communes?codePostal=';
    const formatPostcode = '&format=json' + '&boost=population&limit=3';
    let searchPostCode = $('#searchPostCode');
    let postcode = $('#postcode')
    let errorMessage = $('error-message');


    /* ------------Recherche API avec CODE POSTAL écrit par USER !!!! ------------*/
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
                    $(postcode).append('<option value="' + value.nom + '" id="streetId">' + value.nom + '</option>');

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
    let coordonneeX = $('#coordonneesX');
    let coordonneeY = $('#coordonneesY');

    /* ------------Recherche API avec le code POSTAL renseigné au dessus !!!! ------------*/
    $(searchStreet).on('keyup', function () {

        let valueStreet = document.getElementById('searchStreet').value;
        let codePostCode = document.getElementById('searchPostCode').value;
        let url = apiUrlStreet + valueStreet + '&postcode=' + codePostCode + formatStreet;

        fetch(url, {method: 'get'}).then(response => response.json()).then(results => {

            $(street).find('option').remove();
            $(coordonneeX).find('option').remove();
            $(coordonneeY).find('option').remove();
            if (results) {
                results.features.forEach((features) => {
                    $(street).append('<option value="' + features.properties.name + '" id="' + features.properties.name + '">' + features.properties.name + '</option>');

                    /*$(coordonneeX).append('<option value="' + features.geometry.coordinates[1] + '" id="' + coordonneesX + '">' + features.geometry.coordinates[1] + '</option>');
                    $(coordonneeY).append('<option value="' + features.geometry.coordinates[0] + '" id="' + coordonneesY + '">' + features.geometry.coordinates[0] + '</option>');*/
                })
            } else {
                if ($(street).val()) {
                    console.log('Erreur de code postal.');
                    $(errorMessage).text('Aucune commune avec ce code postal.').show();
                } else {
                    $(errorMessage).text('').hide();
                }
            }
        }).catch(err => {
            console.log(err);
            $(postcode).find('select').remove();
        });

    })
})

function valCommune() {
    let commune = document.getElementById("postcode").value;

}

function valRue() {
    let rue = document.getElementById("street").value;
    coordonnees(rue);
}

function coordonnees(rue) {
    let valueStreet = rue;
    console.log(valueStreet);
    let codePostCode = document.getElementById('searchPostCode').value;
    let apiUrlStreet = 'https://api-adresse.data.gouv.fr/search/?q=';
    const formatStreet = '&format=json&limit=1';
    let url = apiUrlStreet + valueStreet + '&postcode=' + codePostCode + formatStreet;
    let divCoordonnee = $('#divCoordonnee');
    $(divCoordonnee).find('div').remove();
    fetch(url, {method: 'get'}).then(response => response.json()).then(results => {


        if (results) {
            results.features.forEach((features) => {

                $(divCoordonnee).append('<div value="' + features.geometry.coordinates[1] + '" id="coordonneesY">' + features.geometry.coordinates[1] + '</div>');
                coordonneesY = features.geometry.coordinates[1];
                $(divCoordonnee).append('<div value="' + features.geometry.coordinates[0] + '" id="coordonneesX">' + features.geometry.coordinates[0] + '</div>');
                coordonneesX = features.geometry.coordinates[0];
            })
        } else {
            if ($(street).val()) {
                console.log('Erreur de code postal.');
                $(errorMessage).text('Aucune commune avec ce code postal.').show();
            } else {
                $(errorMessage).text('').hide();
            }
        }
    }).catch(err => {
        console.log(err);
        $(postcode).find('select').remove();
    });


}