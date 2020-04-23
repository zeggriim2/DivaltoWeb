// Ajout d'une image dans l'annonce
$('#add-image').click(function(){

    // Je récupere le numero des futurs champ que je vais créer
    //const index = $('#ad_images div.form-group').length;

    const index = +$('#widgets-counter').val()
    console.log(index)
    
    // Je recupére le prototype des entrées
    const tmpl =  $('#ad_images').data('prototype').replace(/__name__/g, index);
    
    // j'injecte ce code au sein de la div
    $('#ad_images').append(tmpl);

    $('#widgets-counter').val(index + 1)



    // Je gère le bouton supprimé
    handleDeleteButtons();
})

function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    })
}

function updateCompteur(){
    const count = +$("#ad_images div.form-group").length;

    $('#widgets-counter').val(count);
}

updateCompteur();
handleDeleteButtons();

