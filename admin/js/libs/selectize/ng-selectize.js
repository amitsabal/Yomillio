(function() {
    angular.module('angular-selectize', []);

    angular.module('angular-selectize').directive('selectize', function($timeout) {
        return {
            // Restrict it to be an attribute in this case
            restrict: 'A',
            require: '?ngModel',
            scope: {
                ngModel: '=',
                options: '='
            },
            // responsible for registering DOM listeners as well as updating the DOM
            link: function(scope, element, attrs, ngModel) {
                var $element;
                $timeout(function() {
                    //console.log(attrs.ngOptions, scope.tags);
                    $element = $(element).selectize(scope.$eval(attrs.selectize));
                    
                    if(!ngModel){
                        //console.log('no ngModel')
                        return;
                    }
                    
                    if (attrs.ngSelectedValue !=undefined) {
                        var $select = $(element).selectize();
                        var selectize = $select[0].selectize;
                        selectize.setValue(attrs.ngSelectedValue);
                    }
                    
                    $(element).selectize().on('change',function(){
                        scope.$apply(function(){
                            var newValue = $(element).selectize().val();
                            ngModel.$setViewValue(newValue);
                        });
                    });
                });
                
                scope.$watch('ngModel', function(val) {
                    console.log('val', val);
                    //if( Object.prototype.toString.call( val ) === '[object Array]' ) {
                    //    console.log("Array");
                    //    var html = "";
                    //    $(val).each(function(){
                    //        html += ('<option value="'+this+'" selected="selected"></option>');
                    //    });
                    //    console.log(html);
                    //    $("#select-tag").append(html);
                    //    $("#test").append(html);
                    //}
                    //else {
                    //    $("#select-tag").append('<option value="'+val+'" selected="selected"></option>');
                    //}
                });
                
                scope.$watch('options', function(val) {
                    var data = scope.$eval(attrs.selectize);
                    data.options = val;
                    try {
                        $(element)[0].selectize.destroy();
                        $element = $(element).selectize(data);
                    }
                    catch(e) {
                        
                    }
                });
                
            }
        };
    });

}).call(this);