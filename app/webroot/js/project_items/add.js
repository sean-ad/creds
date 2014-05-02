/**
* Optional password generation from http://accountspassword.com/password-generator-jquery-plugin
*/


;(function() {
  var App,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  App = (function() {

    function App() {
      this.initialize();
    }

    App.prototype.initialize = function() {
      this.genPass();
    };

    App.prototype.genPass = function() {

        $('#PassGenResultHolder').hide();

        $('#PassGen').pGenerator({
            'bind': 'click',
            'passwordElement': '#ProjectItemPassword',
            'displayElement': '#PassGenResult ',
            'passwordLength': 16,
            'uppercase': true,
            'lowercase': true,
            'numbers':   true,
            'specialChars': true,
            'onPasswordGenerated': function(generatedPassword) {
              $('#PassGenResultHolder').show();
            }
        });

    };

    return App;

  })();

  $(function() {
    return App = new App();
  });

}).call(this);
