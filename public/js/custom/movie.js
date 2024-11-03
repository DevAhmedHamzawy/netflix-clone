$(document).ready(function (){

    let favCount = $('#nav__fav-count').data('fav-count');

    $(document).on('click', '.movie__fav-icon', function(){

        let url = $(this).data('url')
        let movieId = $(this).data('movie-id')
        let isFavorite = $(this).hasClass('fw-900')

        toggleFavorite(url, movieId, isFavorite)

    });


    $(document).on('click', '.movie__fav-btn', function(){

        let url = $(this).find('.movie__fav-icon').data('url')
        let movieId = $(this).find('.movie__fav-icon').data('movie-id')
        let isFavorite = $(this).find('.movie__fav-icon').hasClass('fw-900')

        toggleFavorite(url, movieId, isFavorite)

    });

    function toggleFavorite(url, movieId, isFavorite)
    {

        !isFavorite ? favCount++ : favCount--;

        favCount > 9 ? $('#nav__fav-count').html('9+') : $('#nav__fav-count').html(favCount);

        $('.movie-' + movieId).toggleClass('fw-900');

        if($('.movie-' + movieId).closest('.favorite').length) {
            $('.movie-'+ movieId).closest('.movie').remove();
        }


        $.ajax({
            url: url,
            method: 'POST',

        })
    }


});


