app.directive('datepicker', function(){
        return {
            restrict: 'A',
            require: '?ngModel',
            scope: {
                ngModel: '=',
                curData: '='
            },
            link: function(scope, element, attrs,ngModel){
                var attr = {format:"yyyy-mm-dd"};

                /*if(attrs.format != undefined) attr.format = attrs.format;
                if(attrs.startDate != undefined) {
                    if(attrs.startDate == 'current')
                        attr.startDate = new Date();
                    else
                        attr.startDate = new Date(attrs.startDate);
                }*/ //scope.curData.startDate;
                
                $(element).datepicker(attr);
                $('input',element).change(function() {
                    ngModel.$setViewValue($(this).val());
                });
                //console.log(new Date('2015-03-01'));
                //scope.$watch('ngModel', function(newval, oldval){
                //    if(scope.curData != undefined && scope.curData.startDate != undefined && scope.curData.endDate != undefined)
                //    if(scope.curData.endDate < scope.curData.startDate) {
                //        scope.curData.endDate = '';
                //    };
                //});
            }
        };
    });

app.filter('to_timestamp', function(){
    return function(dateString){
        // Split timestamp into [ Y, M, D, h, m, s ]
        var t = dateString.split(/[- :]/);
        
        // Apply each element to the Date function
        var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
        
        return d.getTime();
    }
})