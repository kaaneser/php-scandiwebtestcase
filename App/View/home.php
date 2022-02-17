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
                <h2>Product List</h2>
            </div>
            <div class="col-auto">
                <button @click="addProductPage()" type="button" class="btn btn-outline-success">Add</button>
                <button @click="deleteProducts()" type="button" class="btn btn-outline-danger">Mass Delete</button>
            </div>
        </div>
        <!-- Products Section -->
        <div class="row row-cols-4 pb-5">
            <!-- Single Card -->
            <div v-for="product in productList" class="col pt-4">
                <div class="px-2 border border-3 border bg-light" style="border-radius: 25px;">
                    <div class="p-2">
                        <input type="checkbox" class="form-input-checkbox" :id="product.SKU" :value="product.SKU" v-model="selectedComponents">
                    </div>
                    <div class="text-center">
                        <p>{{ product.SKU }}</p>
                        <p>{{ product.Name }}</p>
                        <p>{{ product.Price | toDecimal }} $</p>
                        <p v-if="product.Size != null">Size: {{ product.Size }} MB</p>
                        <p v-else-if="product.Weight != null">Weight: {{ product.Weight }} KG</p>
                        <p v-else>Dimension: {{ [product.Height, product.Width, product.Length] | toDimension }}</p>
                    </div>
                </div>
            </div>
            <!-- Single Card End -->
        </div>
        <footer class="px-2 pt-5 border-top border-3 border-dark">
            <h5 class="text-center">Scandiweb Test Assignment</h5>
        </footer>
    </div>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: "#app",
            data: {
                productList: null,
                addProduct: "/addproduct",
                homePage: "/",
                selectedComponents: []
            },
            methods: {
                async deleteProducts() {
                    var formData = new FormData();
                    formData.append('productList', this.selectedComponents);

                    await axios.post('/massDelete', formData).then((res) => {
                        console.log(res);
                    });
                    window.location.href = this.homePage;
                },
                addProductPage() {
                    window.location.href = this.addProduct;
                }
            },
            async created() {
                await axios.get('/getProducts').then((res) => {
                    this.productList = res.data;
                });
            },
            filters: {
                toDecimal (value) {
                    return Number(value).toFixed(2);
                },
                toDimension (value) {
                    return value.join("x");
                }
            }
        })
    </script>
</body>
</html>