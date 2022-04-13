$(document).ready(function (){
    let apiUrl = 'https://geo.api.gouv.fr/communes?nom=';
    const format = '&format=json'+'&fields=departement&boost=population&limit=5';

    let postcode = $('#postcode');
    let city = $('#city');
    let errorMessage = $('error-message');

    $(postcode).on('keyup', function () {
        let code = $(this).val();
        let url = apiUrl+code+format;

        fetch(url,{method : 'get'}).then(response => response.json()).then(results =>{
            //console.log(results);
            $(city).find('option').remove();
            if(results.length){
                $.each(results, function (key, value){
                    //console.log(value);
                    console.log(value.nom);
                    $(city).append('<option value="'+value.nom+'">'+value.nom+'</option>');
                });
            }
            else{
                if($(postcode).val()){
                    console.log('Erreur de code postal.');
                    $(errorMessage).text('Aucune commune avec ce code postal.').show();
                }
                else{
                    $(errorMessage).text('').hide()
                }
            }
        }).catch(err => {
            console.log(err);
            $(city).find('option').remove();
        });
    });
});