(function () {
  yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js?a=4', 'BODY', 'jquery', function () {
    $('.table-view-span').click(function(){
      $('.pricing-table').toggleClass('hide-table');
    });
  });
}());