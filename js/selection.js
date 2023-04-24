/**
 * This function checks whether 11 player is selected all total or not also
 * checks for the no of batsmen, bowler, all rounders. If that's withing the 
 * permissible limit then it allows for submission else keeps the button
 * disabled.
 */
$(document).ready(function () {
  // Listens for the change of checkbox states.
  $('input[type="checkbox"]').change(function () {
      const checkedPlayers = $('input[type="checkbox"]:checked');
      const batsmenSelected = $('input[type="checkbox"]:checked[value^="BAT"]').length;
      const allroundersSelected = $('input[type="checkbox"]:checked[value^="AR"]').length;
      const bowlersSelected = $('input[type="checkbox"]:checked[value^="BOW"]').length;
      const totalPoints = Array.from(checkedPlayers).reduce((sum, player) => sum + parseInt($(player).data('points')), 0);
      // Checking for permissible limit.
      if (checkedPlayers.length === 11 && batsmenSelected === 5 && allroundersSelected === 2 && bowlersSelected === 4 && totalPoints <= 100) {
          $('#submitBtn').prop('disabled', false);
      } 
      else {
          $('#submitBtn').prop('disabled', true);
      }
  });

  /**
   * This function takes the details of selected players and make an ajax call.
   */
  $('#submitBtn').click(function () {
      const players = $('input[type="checkbox"]:checked').map(function () {
          return this.value;
      }).get();

      $.ajax({
          url: 'submit_team.php',
          type: 'POST',
          data: {players: players},
          success: function (response) {
              location.reload();
          }
      });
  });
});