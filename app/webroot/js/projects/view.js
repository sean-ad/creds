/**
*
*/
;(function() {
  var App,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  App = (function() {
  	// Constructor
    function App() {
      this.initialize();
    }

    App.prototype.initialize = function() {
      // Allow to delete users using twitter bootstrap modal
      this.deleteUserModal();

      // Store the original lplaceholder deletion link
      var _del_placeholder = $('.delete-credentials-link').attr('href');

      // Replace the link with the placeholder if they cancel the delete action
      $('#CredentialsModal').on('hidden.bs.modal', function () {
        $('.delete-credentials-link').attr('href', _del_placeholder);
      });


    };

    // Delete users modal
    App.prototype.deleteUserModal = function() {

      // Changes the ID to delete on each user click
      $('.btn-remove-modal').bind('click',function(e) {
        var uid,name,href,pattern,$label,$link;

        $label  = $('.label-uname');
        $link   = $('.delete-credentials-link');
        uid     = $(this).attr('data-uid');
        name    = $(this).attr('data-uname');
        href    = $link.attr('href');
        pattern = '#{uid}';

        // Finds the placeholder in URL and replaces with ID
        aux     = href.replace(pattern,uid);
       $link.attr('href', aux );

        // Changes modal label
        $label.html(name);
      });
    };

    return App;

  })();

  $(function() {
    return App = new App();
  });

}).call(this);
