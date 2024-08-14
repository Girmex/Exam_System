$(document).ready(function() {
    var table = $('#questions').DataTable({
    });

    // Reinitialize custom behavior after each table redraw
    table.on('draw.dt', function() {
        // Make rows editable
        $('.edit_question').click(function(){
            // Your edit question logic
        });

        // Make rows removable
        $('.remove_question').click(function(){
            // Your remove question logic
        });
    });
});
