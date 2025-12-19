/* Feedback AJAX handler */
$(document).ready(function(){
    // initialize modal if Materialize loaded
    if (typeof M !== 'undefined' && M.Modal) {
        var elems = document.querySelectorAll('.modal');
        M.Modal.init(elems);
    }

    // initialize selects
    if (typeof M !== 'undefined' && M.FormSelect) {
        var selects = document.querySelectorAll('select');
        M.FormSelect.init(selects);
    }

    $('#feedback-form').on('submit', function(e){
        e.preventDefault();
        var $form = $(this);
        var $btn = $('#feedback-submit');
        $btn.prop('disabled', true);

        $.ajax({
            url: '/RestroGirls/backends/feedback.php',
            method: 'POST',
            data: $form.serialize(),
            dataType: 'json'
        }).done(function(resp){
            if (resp && resp.status === 'success'){
                if (typeof M !== 'undefined' && M.toast) M.toast({html: resp.message});
                $form[0].reset();
                // close modal
                if (typeof M !== 'undefined' && M.Modal) {
                    var modal = M.Modal.getInstance(document.getElementById('feedback-modal'));
                    if (modal) modal.close();
                }
            } else {
                var msg = (resp && resp.message) ? resp.message : 'Submission failed';
                if (typeof M !== 'undefined' && M.toast) M.toast({html: msg});
            }
        }).fail(function(){
            if (typeof M !== 'undefined' && M.toast) M.toast({html: 'Server error. Try again later.'});
        }).always(function(){
            $btn.prop('disabled', false);
        });
    });
});
