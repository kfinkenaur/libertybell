'use strict';


angular.module('ngCart', ['ngCart.directives'])

    .config([function () {

    }])

    .provider('$ngCart', function () {
        this.$get = function () {
        };
    })

    .run(['$rootScope', 'ngCart','ngCartItem','ngCartBox','store', function ($rootScope, ngCart, ngCartItem, ngCartBox, store) {

        $rootScope.$on('ngCart:change', function(){
            ngCart.$save();
        });

        if (angular.isObject(store.get('cart'))) {
            ngCart.$restore(store.get('cart'));

        } else {
            ngCart.init();
        }

    }])

    .service('ngCart', ['$rootScope', 'ngCartItem', 'ngCartBox', 'store', function ($rootScope, ngCartItem, ngCartBox, store) {

        this.init = function(){
            this.$cart = {
                shipping : null,
                taxRate : null,
                tax : null,
                items : [],
                boxes : [],
                categories : []
            };
        };

        this.addItem = function (id, name, price, weight, size, quantity, category, categoryquantity, data) {

            //console.log('category : '+category);
            //console.log('category qty : '+categoryquantity);
            var inCart = this.getItemById(id);

            //console.log('incart : '+inCart);

            if (typeof inCart === 'object'){
                //Update quantity of an item if it's already in the cart
                inCart.setQuantity(quantity, false);
            } else {
                var newItem = new ngCartItem(id, name, price, weight, size, quantity, category, categoryquantity, data);
                this.$cart.items.push(newItem);
                /*if(this.$cart.categories[category]){
                    console.log('already category qty : '+this.$cart.categories[category]);
                    this.$cart.categories[category] = parseInt(this.$cart.categories[category]) + parseInt(categoryquantity);
                } else {
                    this.$cart.categories[category] = categoryquantity;
                }*/
                $rootScope.$broadcast('ngCart:itemAdded', newItem);
            }

            $rootScope.$broadcast('ngCart:change', {});

            //console.log('cate '+this.getCategoryQuantity(category));
            //console.log(this.$cart);
        };

        this.addBox = function (id, name, price, weight, size, quantity, category, categoryquantity, data) {

            //console.log('category : '+category);
            //console.log('category qty : '+categoryquantity);
            var inCart = this.getBoxById(id);

            //console.log('incart : '+inCart);

            if (typeof inCart === 'object'){
                //Update quantity of an box if it's already in the cart
                inCart.setQuantity(quantity, false);
            } else {
                var newBox = new ngCartBox(id, name, price, weight, size, quantity, category, categoryquantity, data);
                this.$cart.boxes.push(newBox);

                /*if(this.$cart.categories[category]){
                    console.log('already category qty : '+this.$cart.categories[category]);
                    this.$cart.categories[category] = parseInt(this.$cart.categories[category]) + parseInt(categoryquantity);
                } else {
                    this.$cart.categories[category] = categoryquantity;
                }*/
                $rootScope.$broadcast('ngCart:boxAdded', newBox);
            }

            $rootScope.$broadcast('ngCart:change', {});

            //console.log('cate '+this.getCategoryQuantity(category));
            console.log(this.$cart.boxes);
        };

        this.getItemById = function (itemId) {
            var items = this.getCart().items;
            var build = false;

            angular.forEach(items, function (item) {
                if  (item.getId() === itemId) {
                    build = item;
                }
            });
            return build;
        };

        this.getBoxById = function (boxId) {
            var boxes = this.getCart().boxes;
            var build = false;

            angular.forEach(boxes, function (box) {
                if  (box.getId() === boxId) {
                    build = box;
                }
            });
            return build;
        };

        this.setCategoryQuantity = function(quantity, category){
            //console.log(quantity);
           // console.log(category);
            /*var quantityInt = parseInt(quantity);
            if (quantityInt % 1 === 0){
                if (relative === true){
                    this._quantity  += quantityInt;
                } else {
                    this._quantity = quantityInt;
                }
                if (this._quantity < 1){
                  this._quantity = 1;
                } 

            } else {
                this.$cart.category.quantity = 1;
                $log.info('Quantity must be an integer and was defaulted to 1');
            }
            $rootScope.$broadcast('ngCart:change', {});*/
        };

        this.getCategoryQuantity = function(category){
            return this.$cart.category.quantity
        };

        this.setShipping = function(shipping){
            this.$cart.shipping = shipping;
            return this.getShipping();
        };

        this.getShipping = function(){
            if (this.getCart().items.length == 0) return 0;
            return  this.getCart().shipping;
        };

        this.setTaxRate = function(taxRate){
            this.$cart.taxRate = +parseFloat(taxRate).toFixed(2);
            return this.getTaxRate();
        };

        this.getTaxRate = function(){
            return this.$cart.taxRate
        };

        this.getTax = function(){
            return +parseFloat(((this.getSubTotal()/100) * this.getCart().taxRate )).toFixed(2);
        };

        this.setCart = function (cart) {
            this.$cart = cart;
            return this.getCart();
        };

        this.getCart = function(){
            return this.$cart;
        };

        this.getItems = function(){
            return this.getCart().items;
        };

        this.getBoxes = function(){
            return this.getCart().boxes;
        };

        this.getTotalInventoryItems = function () {
            var count = 0;
            var items = this.getItems();
            angular.forEach(items, function (item) {
                count += item.getQuantity();
            });

            var boxes = this.getBoxes();
            angular.forEach(boxes, function (box) {
                count += box.getQuantity();
            });
            return count;
        };

        this.getTotalItems = function () {
            var count = 0;
            var items = this.getItems();
            angular.forEach(items, function (item) {
                count += item.getQuantity();
            });
            return count;
        };

        this.getTotalBoxes = function () {
            var count = 0;
            var boxes = this.getBoxes();
            angular.forEach(boxes, function (box) {
                count += box.getQuantity();
            });
            return count;
        };

        this.getTotalUniqueItems = function () {
            return this.getCart().items.length;
        };

        this.getSubTotal = function(){
            var total = 0;
            angular.forEach(this.getCart().items, function (item) {
                total += item.getTotal();
            });
            return +parseFloat(total).toFixed(2);
        };

        this.totalCost = function () {
            //return +parseFloat(this.getSubTotal() + this.getShipping() + this.getTax()).toFixed(2);
            return +parseFloat(this.getSubTotal()).toFixed(2);
        };

        this.totalCF = function () {
            var total = 0;
            angular.forEach(this.getCart().items, function (item) {
                //console.log(item);
                total += item.getTotalCF();
            });
            angular.forEach(this.getCart().boxes, function (box) {
                //console.log(item);
                total += box.getTotalCF();
            });
            return +parseFloat(total).toFixed(2); 
            //return +parseFloat(this.getSubTotal() + this.getShipping() + this.getTax()).toFixed(2);
        };

        this.countCategoryQuantities = function (category) {
            this.getCart().categories = [];
            //console.log(this.getCart().categories);
            var categoriesArr = this.getCart().categories;
            angular.forEach(this.getCart().items, function (item) {
                //console.log(categoriesArr[item.getCategory()]);
                if(categoriesArr[item.getCategory()]){
                    categoriesArr[item.getCategory()] = parseInt(categoriesArr[item.getCategory()]) + parseInt(item.getCategoryQuantity());
                } else {
                    categoriesArr[item.getCategory()] = parseInt(item.getCategoryQuantity());
                }
            });
            //console.log(categoriesArr);
            this.getCart().categories = categoriesArr;
            //console.log(this.getCart().categories);
            if(category){
                return this.getCart().categories[category];
            } else {
                return this.getCart().categories;
            }
            //return +parseFloat(total).toFixed(2); 
            //return +parseFloat(this.getSubTotal() + this.getShipping() + this.getTax()).toFixed(2);
        };

        this.removeItem = function (index) {
            this.$cart.items.splice(index, 1);
            $rootScope.$broadcast('ngCart:itemRemoved', {});
            $rootScope.$broadcast('ngCart:change', {});

        };

        this.removeBox = function (index) {
            this.$cart.boxes.splice(index, 1);
            $rootScope.$broadcast('ngCart:boxRemoved', {});
            $rootScope.$broadcast('ngCart:change', {});

        };

        this.removeItemById = function (id) {
            var cart = this.getCart();
            angular.forEach(cart.items, function (item, index) {
                if  (item.getId() === id) {
                    //console.log(index);
                    cart.items.splice(index, 1);
                }
            });
            this.setCart(cart);
            $rootScope.$broadcast('ngCart:itemRemoved', {});
            $rootScope.$broadcast('ngCart:change', {});
        };

        this.removeBoxById = function (id) {
            var cart = this.getCart();
            angular.forEach(cart.boxes, function (box, index) {
                if  (box.getId() === id) {
                    //console.log(index);
                    cart.boxes.splice(index, 1);
                }
            });
            this.setCart(cart);
            $rootScope.$broadcast('ngCart:boxRemoved', {});
            $rootScope.$broadcast('ngCart:change', {});
        };

        this.empty = function () {
            
            $rootScope.$broadcast('ngCart:change', {});
            this.$cart.items = [];
            this.$cart.boxes = [];
            this.$cart.categories = [];
            localStorage.removeItem('cart');
        };

        this.toObject = function() {

            if (this.getItems().length === 0) return false;

            var items = [];
            angular.forEach(this.getItems(), function(item){
                items.push (item.toObject());
            });

            var boxes = [];
            angular.forEach(this.getBoxes(), function(box){
                boxes.push (box.toObject());
            });

            return {
                shipping: this.getShipping(),
                tax: this.getTax(),
                taxRate: this.getTaxRate(),
                subTotal: this.getSubTotal(),
                totalCost: this.totalCost(),
                items:items,
                boxes:boxes
            }
        };


        this.$restore = function(storedCart){
            var _self = this;
            _self.init();
            _self.$cart.shipping = storedCart.shipping;
            _self.$cart.tax = storedCart.tax;

            angular.forEach(storedCart.items, function (item) {
                _self.$cart.items.push(new ngCartItem(item._id, item._name, item._price, item._weight, item._size, item._quantity, item._category, item._categoryquantity, item._data));
            });
            angular.forEach(storedCart.boxes, function (box) {
                _self.$cart.boxes.push(new ngCartBox(box._id, box._name, box._price, box._weight, box._size, box._quantity, box._category, box._categoryquantity, box._data));
            });
            this.$save();
        };

        this.$save = function () {
            return store.set('cart', JSON.stringify(this.getCart()));
        }

    }])

    .factory('ngCartItem', ['$rootScope', '$log', function ($rootScope, $log) {

        var item = function (id, name, price, weight, size, quantity, category, categoryquantity, data) {
            this.setId(id);
            this.setName(name);
            this.setPrice(price);
            this.setWeight(weight);
            this.setSize(size);
            this.setQuantity(quantity);
            this.setCategory(category);
            this.setCategoryQuantity(categoryquantity);            
            this.setData(data);
        };


        item.prototype.setId = function(id){
            if (id)  this._id = id;
            else {
                $log.error('An ID must be provided');
            }
        };

        item.prototype.getId = function(){
            return this._id;
        };


        item.prototype.setName = function(name){
            if (name)  this._name = name;
            else {
                $log.error('A name must be provided');
            }
        };
        item.prototype.getName = function(){
            return this._name;
        };

        item.prototype.setPrice = function(price){
            var priceFloat = parseFloat(price);
            if (priceFloat) {
                if (priceFloat <= 0) {
                    $log.error('A price must be over 0');
                } else {
                    this._price = (priceFloat);
                }
            } else {
                $log.error('A price must be provided');
            }
        };
        item.prototype.getPrice = function(){
            return this._price;
        };


        item.prototype.setQuantity = function(quantity, relative){


            var quantityInt = parseInt(quantity);
            if (quantityInt % 1 === 0){
                if (relative === true){
                    this._quantity  += quantityInt;
                } else {
                    this._quantity = quantityInt;
                }
                if (this._quantity < 1){
                  this._quantity = 1;
                } 

            } else {
                this._quantity = 1;
                $log.info('Quantity must be an integer and was defaulted to 1');
            }
            this.setCategoryQuantity(this._quantity, false);
            $rootScope.$broadcast('ngCart:change', {});

        };

        item.prototype.getQuantity = function(){
            return this._quantity;
        };

        item.prototype.setWeight = function(weight){
            //console.log(weight);
            var weightFloat = parseFloat(weight);
            if (weightFloat) {
                if (weightFloat <= 0) {
                    $log.error('A weight must be over 0');
                } else {
                    this._weight = (weightFloat);
                }
            } else {
                $log.error('A weight must be provided');
            }
        };
        item.prototype.getWeight = function(){
            //console.log('getw:'+this._weight);
            return this._weight;
        };

        item.prototype.setSize = function(size){
            var sizeFloat = parseFloat(size);
            if (sizeFloat) {
                if (sizeFloat <= 0) {
                    $log.error('A size must be over 0');
                } else {
                    this._size = (sizeFloat);
                }
            } else {
                $log.error('A size must be provided');
            }
        };
        item.prototype.getSize = function(){
            return this._size;
        };

        item.prototype.setCategory = function(category){
            if (category) this._category = parseInt(category);
        };

        item.prototype.getCategory = function(){
            if (this._category) return this._category;
            else $log.info('This item has no category');
        };

        item.prototype.setCategoryQuantity = function(categoryquantity, relative){


            var categoryquantityInt = parseInt(categoryquantity);
            if (categoryquantityInt % 1 === 0){
                if (relative === true){
                    this._categoryquantity  += categoryquantityInt;
                } else {
                    this._categoryquantity = categoryquantityInt;
                }
                if (this._categoryquantity < 1){
                  this._categoryquantity = 1;
                } 

            } else {
                this._categoryquantity = 1;
                $log.info('Category Quantity must be an integer and was defaulted to 1');
            }
            $rootScope.$broadcast('ngCart:change', {});

        };

        item.prototype.getCategoryQuantity = function(){
            return this._categoryquantity;
        };

        item.prototype.setData = function(data){
            if (data) this._data = data;
        };

        item.prototype.getData = function(){
            if (this._data) return this._data;
            else $log.info('This item has no data');
        };


        item.prototype.getTotal = function(){
            //console.log(+parseFloat(this.getQuantity() * this.getPrice()).toFixed(2));
            return +parseFloat(this.getQuantity() * this.getPrice()).toFixed(2);
        };

        item.prototype.getTotalCF = function(){
            return +parseFloat(this.getQuantity() * this.getSize()).toFixed(2);
        };

        item.prototype.getTotalWeight = function(){
            //console.log(this.getWeight());
            return +parseFloat(this.getQuantity() * this.getWeight()).toFixed(2);
        };

        item.prototype.toObject = function() {
            return {
                id: this.getId(),
                name: this.getName(),
                price: this.getPrice(),
                weight: this.getWeight(),
                size: this.getSize(),
                quantity: this.getQuantity(),
                category: this.getCategory(),
                categoryquantity: this.getCategoryQuantity(),
                data: this.getData(),
                total: this.getTotal(),
                totalcf: this.getTotalCF()
            }
        };

        return item;

    }])

    .factory('ngCartBox', ['$rootScope', '$log', function ($rootScope, $log) {

        var box = function (id, name, price, weight, size, quantity, category, categoryquantity, data) {
            this.setId(id);
            this.setName(name);
            this.setPrice(price);
            this.setWeight(weight);
            this.setSize(size);
            this.setQuantity(quantity);
            this.setCategory(category);
            this.setCategoryQuantity(categoryquantity);            
            this.setData(data);
        };


        box.prototype.setId = function(id){
            if (id)  this._id = id;
            else {
                $log.error('An ID must be provided');
            }
        };

        box.prototype.getId = function(){
            return this._id;
        };


        box.prototype.setName = function(name){
            if (name)  this._name = name;
            else {
                $log.error('A name must be provided');
            }
        };
        box.prototype.getName = function(){
            return this._name;
        };

        box.prototype.setPrice = function(price){
            var priceFloat = parseFloat(price);
            if (priceFloat) {
                if (priceFloat <= 0) {
                    $log.error('A price must be over 0');
                } else {
                    this._price = (priceFloat);
                }
            } else {
                $log.error('A price must be provided');
            }
        };
        box.prototype.getPrice = function(){
            return this._price;
        };


        box.prototype.setQuantity = function(quantity, relative){


            var quantityInt = parseInt(quantity);
            if (quantityInt % 1 === 0){
                if (relative === true){
                    this._quantity  += quantityInt;
                } else {
                    this._quantity = quantityInt;
                }
                if (this._quantity < 1){
                  this._quantity = 1;
                } 

            } else {
                this._quantity = 1;
                $log.info('Quantity must be an integer and was defaulted to 1');
            }
            this.setCategoryQuantity(this._quantity, false);
            $rootScope.$broadcast('ngCart:change', {});

        };

        box.prototype.getQuantity = function(){
            return this._quantity;
        };

        box.prototype.setWeight = function(weight){
            //console.log(weight);
            var weightFloat = parseFloat(weight);
            if (weightFloat) {
                if (weightFloat <= 0) {
                    $log.error('A weight must be over 0');
                } else {
                    this._weight = (weightFloat);
                }
            } else {
                $log.error('A weight must be provided');
            }
        };
        box.prototype.getWeight = function(){
            //console.log('getw:'+this._weight);
            return this._weight;
        };

        box.prototype.setSize = function(size){
            var sizeFloat = parseFloat(size);
            if (sizeFloat) {
                if (sizeFloat <= 0) {
                    $log.error('A size must be over 0');
                } else {
                    this._size = (sizeFloat);
                }
            } else {
                $log.error('A size must be provided');
            }
        };
        box.prototype.getSize = function(){
            return this._size;
        };

        box.prototype.setCategory = function(category){
            if (category) this._category = parseInt(category);
        };

        box.prototype.getCategory = function(){
            if (this._category) return this._category;
            else $log.info('This box has no category');
        };

        box.prototype.setCategoryQuantity = function(categoryquantity, relative){


            var categoryquantityInt = parseInt(categoryquantity);
            if (categoryquantityInt % 1 === 0){
                if (relative === true){
                    this._categoryquantity  += categoryquantityInt;
                } else {
                    this._categoryquantity = categoryquantityInt;
                }
                if (this._categoryquantity < 1){
                  this._categoryquantity = 1;
                } 

            } else {
                this._categoryquantity = 1;
                $log.info('Category Quantity must be an integer and was defaulted to 1');
            }
            $rootScope.$broadcast('ngCart:change', {});

        };

        box.prototype.getCategoryQuantity = function(){
            return this._categoryquantity;
        };

        box.prototype.setData = function(data){
            if (data) this._data = data;
        };

        box.prototype.getData = function(){
            if (this._data) return this._data;
            else $log.info('This box has no data');
        };


        box.prototype.getTotal = function(){
            //console.log(+parseFloat(this.getQuantity() * this.getPrice()).toFixed(2));
            return +parseFloat(this.getQuantity() * this.getPrice()).toFixed(2);
        };

        box.prototype.getTotalCF = function(){
            return +parseFloat(this.getQuantity() * this.getSize()).toFixed(2);
        };

        box.prototype.getTotalWeight = function(){
            //console.log(this.getWeight());
            return +parseFloat(this.getQuantity() * this.getWeight()).toFixed(2);
        };

        box.prototype.toObject = function() {
            return {
                id: this.getId(),
                name: this.getName(),
                price: this.getPrice(),
                weight: this.getWeight(),
                size: this.getSize(),
                quantity: this.getQuantity(),
                category: this.getCategory(),
                categoryquantity: this.getCategoryQuantity(),
                data: this.getData(),
                total: this.getTotal(),
                totalcf: this.getTotalCF()
            }
        };

        return box;

    }])

    .service('store', ['$window', function ($window) {

        return {

            get: function (key) {
                if ($window.localStorage [key]) {
                    var cart = angular.fromJson($window.localStorage [key]);
                    return JSON.parse(cart);
                }
                return false;

            },


            set: function (key, val) {

                if (val === undefined) {
                    $window.localStorage .removeItem(key);
                } else {
                    $window.localStorage [key] = angular.toJson(val);
                }
                return $window.localStorage [key];
            }
        }
    }])

    .controller('CartController',['$scope', 'ngCart', function($scope, ngCart) {
        $scope.ngCart = ngCart;

    }])

    .value('version', '0.0.3-rc.1');
;'use strict';


angular.module('ngCart.directives', ['ngCart.fulfilment'])

    .controller('CartController',['$scope', 'ngCart', function($scope, ngCart) {
        $scope.ngCart = ngCart;
    }])

    .directive('ngcartAddtocart', ['ngCart', function(ngCart){
        return {
            restrict : 'E',
            controller : 'CartController',
            scope: {
                id:'@',
                name:'@',
                quantity:'@',
                quantityMax:'@',
                price:'@',
                weight:'@',
                size:'@',
                category:'@',
                categoryquantity:'@',
                data:'='
            },
            transclude: true,
            templateUrl: 'template/ngCart/addtocart.html',
            link:function(scope, element, attrs){
                scope.attrs = attrs;
                scope.inCart = function(){
                    return  ngCart.getItemById(attrs.id);
                };

                if (scope.inCart()){
                    scope.q = ngCart.getItemById(attrs.id).getQuantity();
                } else {
                    scope.q = parseInt(scope.quantity);
                }

                scope.qtyOpt =  [];
                for (var i = 1; i <= scope.quantityMax; i++) {
                    scope.qtyOpt.push(i);
                }

            }

        };
    }])

    .directive('ngcartAddboxtocart', ['ngCart', function(ngCart){
        return {
            restrict : 'E',
            controller : 'CartController',
            scope: {
                id:'@',
                name:'@',
                quantity:'@',
                quantityMax:'@',
                price:'@',
                weight:'@',
                size:'@',
                category:'@',
                categoryquantity:'@',
                data:'='
            },
            transclude: true,
            templateUrl: 'template/ngCart/addboxtocart.html',
            link:function(scope, element, attrs){
                scope.attrs = attrs;
                scope.inCart = function(){
                    return  ngCart.getBoxById(attrs.id);
                };

                if (scope.inCart()){
                    scope.q = ngCart.getBoxById(attrs.id).getQuantity();
                } else {
                    scope.q = parseInt(scope.quantity);
                }

                scope.qtyOpt =  [];
                for (var i = 1; i <= scope.quantityMax; i++) {
                    scope.qtyOpt.push(i);
                }

            }

        };
    }])

    .directive('ngcartCart', [function(){
        return {
            restrict : 'E',
            controller : 'CartController',
            scope: {},
            templateUrl: 'template/ngCart/cart.html',
            link:function(scope, element, attrs){

            }
        };
    }])

    .directive('ngcartSummary', [function(){
        return {
            restrict : 'E',
            controller : 'CartController',
            scope: { id:'@' },
            transclude: true,
            templateUrl: 'template/ngCart/summary.html'
        };
    }])

    .directive('ngcartPrintsummary', [function(){
        return {
            restrict : 'E',
            controller : 'CartController',
            scope: { id:'@' },
            transclude: true,
            templateUrl: 'template/ngCart/printsummary.html'
        };
    }])

    .directive('ngcartEmailsummary', [function(){
        return {
            restrict : 'E',
            controller : 'CartController',
            scope: { id:'@' },
            transclude: true,
            templateUrl: 'template/ngCart/emailsummary.html'
        };
    }])

    .directive('ngcartReview', [function(){
        return {
            restrict : 'E',
            controller : 'CartController',
            scope: { id:'@' },
            transclude: true,
            templateUrl: 'template/ngCart/review.html'
        };
    }])

    .directive('ngcartPrintreview', [function(){
        return {
            restrict : 'E',
            controller : 'CartController',
            scope: { id:'@' },
            transclude: true,
            templateUrl: 'template/ngCart/printreview.html'
        };
    }])

    .directive('ngcartCheckout', [function(){
        return {
            restrict : 'E',
            controller : ('CartController', ['$scope', 'ngCart', 'fulfilmentProvider', function($scope, ngCart, fulfilmentProvider) {
                $scope.ngCart = ngCart;

                $scope.checkout = function () {
                    fulfilmentProvider.setService($scope.service);
                    fulfilmentProvider.setSettings($scope.settings);
                    var promise = fulfilmentProvider.checkout();
                    //console.log(promise);
                }
            }]),
            scope: {
                service:'@',
                settings:'='
            },
            transclude: true,
            templateUrl: 'template/ngCart/checkout.html'
        };
    }]);;
angular.module('ngCart.fulfilment', [])
    .service('fulfilmentProvider', ['$injector', function($injector){

        this._obj = {
            service : undefined,
            settings : undefined
        };

        this.setService = function(service){
            this._obj.service = service;
        };

        this.setSettings = function(settings){
            this._obj.settings = settings;
        };

        this.checkout = function(){
            var provider = $injector.get('ngCart.fulfilment.' + this._obj.service);
              return provider.checkout(this._obj.settings);

        }

    }])


.service('ngCart.fulfilment.log', ['$q', '$log', 'ngCart', function($q, $log, ngCart){

        this.checkout = function(){

            var deferred = $q.defer();

            $log.info(ngCart.toObject());
            deferred.resolve({
                cart:ngCart.toObject()
            });

            return deferred.promise;

        }

 }])

.service('ngCart.fulfilment.http', ['$http', 'ngCart', function($http, ngCart){

        this.checkout = function(settings){
            return $http.post(settings.url,
                {data:ngCart.toObject()})
        }
 }])


.service('ngCart.fulfilment.paypal', ['$http', 'ngCart', function($http, ngCart){


}]);
