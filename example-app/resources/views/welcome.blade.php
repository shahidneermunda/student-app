<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <title>Student App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
</head>
<body ng-controller="StudentController">

<div class="container">
    <h2>Create Student <span><button ng-click="addNewRow();" class="btn btn-primary pull-right">ADD</button></span></h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>COUNTRY</th>
            <th>STATE</th>
            <th>IMAGE</th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="newstudent in newstudents">
            <td>@{{$index+1}}</td>
            <td><input ng-model="newstudent.name" type="text" class="form-control"></td>
            <td>
                <select ng-model="newstudent.country_id" ng-change="getState(newstudent.country_id);" class="form-control">
                    <option value="">Select</option>
                    <option ng-repeat="country in countries" value="@{{country.id}}">@{{country.name}}</option>
                </select>
            </td>
            <td>
                <select ng-model="newstudent.state_id" class="form-control">
                    <option value="">Select</option>
                    <option ng-repeat="state in states" value="@{{state.id}}">@{{state.name}}</option>
                </select>
            </td>
            <td>
                <input  class="form-control" accept="image/png, image/gif, image/jpeg" ng-file-model="newstudent.image" type="file" multiple/>
            </td>
        </tr>
        </tbody>
    </table>
    <span><button ng-click="saveStudents(newstudents);" class="btn btn-primary pull-right">SAVE</button></span>
</div>


<div class="container">
    <h2>Student List</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>COUNTRY</th>
            <th>STATE</th>
            <th>IMAGE</th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="student in students">
            <td>@{{student.id}}</td>
            <td>@{{student.name}}</td>
            <td>@{{student.country.name}}</td>
            <td>@{{student.state.name}}</td>
            <td><img src="images/@{{student.image}}" alt=""></td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    var app = angular.
    module('myApp', [

    ]);
    app.controller('StudentController', function($scope,$http){
        $scope.students=[];
        $scope.countries=[];
        $http.get('getstudents')
            .then(function onSuccess(response) {
                $scope.students=response.data;

            }, function myError(response) {

            });
        $http.get('getcountry')
            .then(function onSuccess(response) {
                $scope.countries=response.data;

            }, function myError(response) {

            });

        $scope.newstudents = [{name: '', country_id: '', state_id: '',image:''}];
        $scope.getState=function(country_id){
            $http.post('getstates',{country_id:country_id})
                .then(function onSuccess(response) {
                    $scope.states=response.data;

                }, function myError(response) {

                });
        }

        $scope.addNewRow=function(){
            $scope.newstudents.push({name: '', country_id: '', state_id: '',image:''})
        }

        $scope.saveStudents = function (newstudents) {
            $http.post('savestudents',{students:newstudents})
                .then(function onSuccess(response) {
                    console.log(response.data)
                    $scope.students=response.data;
                }, function myError(response) {

                });
            $scope.newstudents = [{name: '', country_id: '', state_id: '',image:''}];
        };
    });


    app.directive('ngFileModel', ['$parse', function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                var model = $parse(attrs.ngFileModel);
                var isMultiple = attrs.multiple;
                var modelSetter = model.assign;
                element.bind("change", function (changeEvent) {
                    var values = [];

                    for (var i = 0; i < element[0].files.length; i++) {
                        var reader = new FileReader();

                        reader.onload = (function (i) {
                            return function(e) {
                                var value = {
                                    lastModified: changeEvent.target.files[i].lastModified,
                                    lastModifiedDate: changeEvent.target.files[i].lastModifiedDate,
                                    name: changeEvent.target.files[i].name,
                                    size: changeEvent.target.files[i].size,
                                    type: changeEvent.target.files[i].type,
                                    data: e.target.result
                                };
                                values.push(value);
                            }

                        })(i);

                        reader.readAsDataURL(changeEvent.target.files[i]);
                    }


                    scope.$apply(function () {
                        if (isMultiple) {
                            modelSetter(scope, values);
                        } else {
                            modelSetter(scope, values[0]);
                        }
                    });
                });
            }
        }
    }]);
</script>
</body>
</html>

