myApp.constant("API_URL", "");

myApp.filter("jsDate", function () {
    return function (x) {
        return x.replace("/Date(", "").replace(")/", "");
    };
});

myApp.filter('propsFilter', function () {
    return function (items, props) {
        var out = [];

        if (angular.isArray(items)) {
            var keys = Object.keys(props);

            items.forEach(function (item) {
                var itemMatches = false;

                for (var i = 0; i < keys.length; i++) {
                    var prop = keys[i];
                    var text = props[prop].toLowerCase();
                    if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }

                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            // Let the output be the input untouched
            out = items;
        }
        return out;
    };
});

myApp.run(function ($rootScope, $http, $window, API_URL) {
    $rootScope.snackbarContent = "Hello!"
    var myTimeout
    $rootScope.showSnackbar = function (content, kind) {
        $rootScope.snackbarContent = content
        let snackbar = $('#snackbar')
        if (kind == 'error') {
            snackbar.css({ 'background-color': '#F44336' })
            snackbar.css({ 'background-image': 'unset' })
        } else if (kind == 'success') {
            snackbar.css({ 'background-image': 'linear-gradient(to right, #2F80ED, #00AEEF)' })
            snackbar.css({ 'background-color': 'unset' })
        } else if (kind == 'warning') {
            snackbar.css({ 'background-image': 'linear-gradient(45deg, #F2AF12 0%, #FFD200 100%)' })
            snackbar.css({ 'background-color': 'unset' })
        } else {
            snackbar.css({ 'background-color': 'rgba(24, 34, 45, 1)' })
            snackbar.css({ 'background-image': 'unset' })
        }
        if (snackbar.hasClass('show')) {
            snackbar.removeClass('show')
            setTimeout(function () {
                clearTimeout(myTimeout)
                snackbar.addClass('show')
                myTimeout = setTimeout(function () {
                    snackbar.removeClass('show')
                }, 3000);
            }, 100);
        } else {
            snackbar.addClass('show')
            myTimeout = setTimeout(function () {
                snackbar.removeClass('show')
            }, 3000);
        }
    }
    //Như tab controls ấy
    $rootScope.currentIndex = -1
    $rootScope.currentSubIndex = -1
    $rootScope.isActiveNav = function (index) {
        return index == $rootScope.currentIndex
    }
    $rootScope.isActiveSubNav = function (index) {
        return index == $rootScope.currentSubIndex
    }
})
