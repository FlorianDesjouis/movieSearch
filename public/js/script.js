$(function (){
    var search = $('#searchForm');

    search.submit(function () {
        $.ajax({
            method : 'POST',
            url : 'index/search',
            data : $(this).serialize(),
            success : function (data) {
                var filmList = data.films;

                $('#resultat').html('<tr><th>Titre</th><th>Année</th><th>Synopsis</th><th>Durée</th></tr>');
                for(var j in filmList){
                    $('#resultat').append(
                        '<tr><td>' + filmList[j].title + '</td>' +
                        '<td>' + filmList[j].year + '</td>' +
                        '<td>' + filmList[j].synopsis + '</td>' +
                        '<td>' + filmList[j].duration + '</td></tr>'
                    )
                }
            }
        });
        return false;
    });
});