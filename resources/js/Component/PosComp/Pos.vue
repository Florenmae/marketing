<template>
    <posLayout>
        <section
            class="section-content padding-y-sm bg-default"
            style="padding: 50px"
        >
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 card padding-y-sm card">
                        <form
                            action="#"
                            class="search-wrap"
                            style="float: right"
                        >
                            <div class="input-group">
                                <input
                                    type="text"
                                    placeholder="Search"
                                    class="form-control"
                                    v-on:keyup="keymonitor"
                                    v-model="ThisIsField1"
                                />
                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <ul
                            class="nav bg radius nav-pills nav-fill mb-3 bg"
                            role="tablist"
                        ></ul>
                        <span id="items">
                            <div class="row">
                                <div
                                    class="col-md-3"
                                    v-for="product in allproduct"
                                    :key="product.id"
                                >
                                    <figure class="card card-product">
                                        <div class="img-wrap">
                                            <img :src="product.image" />
                                            <a class="btn-overlay" href="#"
                                                ><i
                                                    class="fa fa-search-plus"
                                                ></i>
                                                Quick view</a
                                            >
                                        </div>
                                        <figcaption class="info-wrap">
                                            <a href="#" class="title">{{
                                                product.name
                                            }}</a>
                                            <div class="action-wrap">
                                                <button
                                                    @click="
                                                        addtocart(product.id)
                                                    "
                                                    class="btn btn-primary btn-sm float-right"
                                                >
                                                    <i
                                                        class="fa fa-cart-plus"
                                                    ></i>
                                                    Add
                                                </button>
                                                <div class="price-wrap h5">
                                                    <span class="price-new"
                                                        >$
                                                        {{
                                                            product.price
                                                        }}</span
                                                    >
                                                </div>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <span id="cart">
                                <table
                                    class="table table-hover shopping-cart-wrap table-responsive"
                                >
                                    <thead class="text-muted">
                                        <tr>
                                            <th scope="col">Item</th>
                                            <th scope="col" width="120">Qty</th>
                                            <th scope="col" width="120">
                                                Price
                                            </th>
                                            <th
                                                scope="col"
                                                class="text-right"
                                                width="200"
                                            >
                                                Delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="product in allcartproduct"
                                            :key="product.id"
                                        >
                                            <td>
                                                <figure class="media">
                                                    <div class="img-wrap">
                                                        <img
                                                            :src="product.image"
                                                            class="img-thumbnail img-xs"
                                                        />
                                                    </div>
                                                    <figcaption
                                                        class="media-body"
                                                    >
                                                        <h6
                                                            class="title text-truncate"
                                                        >
                                                            {{ product.name }}
                                                        </h6>
                                                    </figcaption>
                                                </figure>
                                            </td>
                                            <td class="text-center">
                                                <div
                                                    class="m-btn-group m-btn-group--pill btn-group mr-2"
                                                    role="group"
                                                    aria-label="..."
                                                >
                                                    <button
                                                        @click="
                                                            decrement(
                                                                product.id
                                                            )
                                                        "
                                                        type="button"
                                                        class="m-btn btn btn-default"
                                                    >
                                                        <i
                                                            class="fa fa-minus"
                                                        ></i>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="m-btn btn btn-default"
                                                        disabled
                                                    >
                                                        {{ product.quantity }}
                                                    </button>
                                                    <button
                                                        @click="
                                                            increment(
                                                                product.id
                                                            )
                                                        "
                                                        type="button"
                                                        class="m-btn btn btn-default"
                                                    >
                                                        <i
                                                            class="fa fa-plus"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price"
                                                        ><font
                                                            style="
                                                                font-size: 15px;
                                                            "
                                                            >${{
                                                                product.total
                                                            }}</font
                                                        ></var
                                                    >
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button
                                                    @click="
                                                        removefromcart(
                                                            product.id
                                                        )
                                                    "
                                                    class="btn btn-outline-danger"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </span>
                        </div>

                        <div class="box">
                            <dl class="dlist-align">
                                <dt>Tax:</dt>
                                <dd class="text-right">0%</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Discount:</dt>
                                <dd class="text-right"><a href="#">0%</a></dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Sub Total:</dt>
                                <dd class="text-right">${{ sum }}</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Total:</dt>
                                <dd class="text-right h4 b">${{ sum }}</dd>
                            </dl>
                            <hr />
                            <form
                                action="javascript:void(0)"
                                @submit="submitdata"
                                method="post"
                                enctype="multipart/form-data"
                            >
                                <div class="row">
                                    <div
                                        class="col-md-12"
                                        style="padding-bottom: 5px"
                                    >
                                        <p>Customer name :</p>
                                        <input
                                            type="text"
                                            v-model="order.customername"
                                            class="form-control"
                                            placeholder="Customer name"
                                            required
                                        />
                                    </div>

                                    <div class="col-md-12">
                                        <p>Customer phone :</p>
                                        <input
                                            type="text"
                                            v-model="order.customerphone"
                                            class="form-control"
                                            placeholder="Customer phone"
                                            required
                                        />
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-6">
                                        <a
                                            href="#"
                                            class="btn btn-default btn-error btn-lg btn-block"
                                            ><i class="fa fa-times-circle"></i>
                                            Cancel
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-lg btn-block"
                                        >
                                            <i class="fa fa-shopping-bag"></i
                                            >{{
                                                processing
                                                    ? " Please wait"
                                                    : " Submit"
                                            }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </posLayout>
</template>

<script>
export default {
    data() {
        return {
            processing: false,
            allproduct: [],
            ThisIsField1: "",
            search: {
                query: "",
            },
            allcartproduct: [],
            sum: 0,
            order: {
                customername: "",
                customerphone: "",
            },
        };
    },
};
</script>
