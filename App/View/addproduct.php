<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Case - Product List</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div id="app" class="mx-5">
        <!-- Header & Buttons -->
        <div class="row px-2 pt-5 border-bottom border-3 border-dark">
            <div class="col">
                <h2>Product Add</h2>
            </div>
            <div class="col-auto">
                <button @click="saveProduct()" type="button" class="btn btn-outline-success">Save</button>
                <button @click="cancel()" type="button" class="btn btn-outline-danger">Cancel</button>
            </div>
        </div>
        <!-- Add Section -->
        <form class="container">
            <div v-show="notFilledWarn" class="alert alert-danger col-sm-3 my-2">
                Please, submit required data.
            </div>
            <div v-show="wrongTypeWarn" class="alert alert-danger col-sm-3 my-2">
                Please, provide the data of indicated type.
            </div>
            <div class="form-row my-2">
                <label class="col-sm-2 col-form-label" for="sku">SKU *</label>
                <div class="col-md-2 input-group-sm">
                    <input @blur="checkFilled($event.target);" v-model="product['SKU']" id="sku" type="text" class="form-control">
                </div>
            </div>
            <div class="form-row my-2">
                <label class="col-sm-2 col-form-label" for="name">Name *</label>
                <div class="col-md-2 input-group-sm">
                    <input @blur="checkFilled($event.target);" v-model="product['Name']" id="name" type="text" class="form-control">
                </div>
            </div>
            <div class="form-row my-2">
                <label class="col-sm-2 col-form-label" for="price">Price *</label>
                <div class="col-md-2 input-group-sm">
                    <input @blur="checkNumber($event.target); checkFilled($event.target);" v-model="product['Price']" id="price" type="text" class="form-control">
                </div>
            </div>
            <div class="form-row my-2">
                <label class="col-sm-2 col-form-label" for="productType">Product Type *</label>
                <div class="col-md-2">
                    <select id="productType" @change="onChange($event)">
                        <option selected disabled>Please choose a product type</option>
                        <option value="DVD">DVD</option>
                        <option value="Book">Book</option>
                        <option value="Furniture">Furniture</option>
                    </select>
                </div>
            </div>
            <div v-show="selected === 'DVD'" class="form-row my-5">
                <div class="alert alert-secondary col-sm-3">
                    Please provide a size for DVD
                </div>
                <label class="col-sm-2 col-form-label" for="size">Size (MB) *</label>
                <div class="col-md-2 input-group-sm">
                    <input @blur="checkNumber($event.target); checkFilled($event.target);" v-model="product['additionalInfo']['Size']" id="size" type="text" class="form-control">
                </div>
            </div>
            <div v-show="selected === 'Book'" class="form-row my-5">
                <div class="alert alert-secondary col-sm-3">
                    Please provide a weight for Book
                </div>
                <label class="col-sm-2 col-form-label" for="weight">Weight (KG) *</label>
                <div class="col-md-2 input-group-sm">
                    <input @blur="checkNumber($event.target); checkFilled($event.target);" v-model="product['additionalInfo']['Weight']" id="weight" type="text" class="form-control">
                </div>
            </div>
            <div v-show="selected === 'Furniture'" class="form-row my-5">
                <div class="alert alert-secondary col-sm-3">
                    Please provide dimensions for Furniture
                </div>
                <label class="col-sm-2 col-form-label" for="height">Height (CM) *</label>
                <div class="col-md-2 input-group-sm">
                    <input @blur="checkNumber($event.target); checkFilled($event.target);" v-model="product['additionalInfo']['Height']" id="height" type="text" class="form-control">
                </div>
                <label class="col-sm-2 col-form-label" for="width">Width (CM) *</label>
                <div class="col-md-2 input-group-sm">
                    <input @blur="checkNumber($event.target); checkFilled($event.target);" v-model="product['additionalInfo']['Width']" id="width" type="text" class="form-control">
                </div>
                <label class="col-sm-2 col-form-label" for="length">Length (CM) *</label>
                <div class="col-md-2 input-group-sm">
                    <input @blur="checkNumber($event.target); checkFilled($event.target);" v-model="product['additionalInfo']['Length']" id="length" type="text" class="form-control">
                </div>
            </div>
        </form>
        <footer class="px-2 pt-5 border-top border-3 border-dark">
            <h5 class="text-center">Scandiweb Test Assignment</h5>
        </footer>
    </div>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: "#app",
            data: {
                notFilledWarn: false,
                wrongTypeWarn: false,
                selected: null,
                homePage: '/',
                product: {
                    additionalInfo: {} 
                },
                notFilledInputs: []
            },
            methods: {
                checkNumber(val) {
                    if (/^(([0-9]*)|(([0-9]*)\.([0-9]*)))$/.test(val.value)){
                        this.wrongTypeWarn = false;
                    } else {
                        this.wrongTypeWarn = true;
                    }
                },
                checkFilled(target) {
                    if (target.value == "") {
                        this.notFilledWarn = true;
                        if (!this.notFilledInputs.includes(target.id)){
                            this.notFilledInputs.push(target.id);
                        }
                    } else {
                        if (this.notFilledInputs.includes(target.id)){
                            this.notFilledInputs = this.notFilledInputs.filter(function(e) {
                                return e !== target.id;
                            });
                        }
                        if (this.notFilledInputs.length === 0){
                            this.notFilledWarn = false;
                        }
                    }
                },
                onChange(e) {
                    this.selected = e.target.value;
                    this.product['ProductType'] = this.selected;
                    this.product['additionalInfo'] = {};
                    this.notFilledInputs = this.notFilledInputs.filter(function(e) {
                        return e !== 'size' && e !== 'weight' && e !== 'width' && e !== 'length' && e !== 'height';
                    });
                    if (this.notFilledInputs.length === 0) this.notFilledWarn = false;
                },
                cancel() {
                    window.location.href = this.homePage;
                },
                async saveProduct() {
                    var formData = new FormData();
                    await formData.append('product', JSON.stringify(this.product));
                    
                    if (!this.notFilledWarn && !this.wrongTypeWarn){
                        await axios.post('/addProduct', formData).then((res) => {
                            window.location.href = this.homePage;
                        });
                    }
                }
            }
        })
    </script>
</body>
</html>