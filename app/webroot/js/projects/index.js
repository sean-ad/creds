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
      // Allow to delete projects using twitter bootstrap modal
      this.deleteProjectModal();

      // Store the original lplaceholder deletion link
      var _del_placeholder = $('.delete-project-link').attr('href');

      // Replace the link with the placeholder if they cancel the delete action
      $('#ProjectsModal').on('hidden.bs.modal', function () {
        $('.delete-project-link').attr('href', _del_placeholder);
      });

    }

    // Delete users modal
    App.prototype.deleteProjectModal = function() {

      // Changes the URL to delete on each project click
      $('.btn-remove-modal').bind('click',function(e) {
        var uid,name,href,pattern,$label,$link;

        $label  = $('.label-pname');
        $link   = $('.delete-project-link');
        uid     = $(this).attr('data-pid');
        name    = $(this).attr('data-pname');
        href    = $link.attr('href');
        pattern = '#{uid}';

        // Find the last ID in URL
        aux     = href.replace(pattern,uid);

        $link.attr('href', aux );

        // Changes modal label
        $label.html(name);
      });
    }

    return App;

  })();

  $(function() {
    return App = new App();
  });

}).call(this);
