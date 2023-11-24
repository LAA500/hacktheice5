<template>
    <div class="Cart">
        <div class="text-center my-4" v-if="cart.empty">
            <h2 v-text="$lang('cart_empty_title')"></h2>
            <div class="my-4">
                <a
                    :href="$link('link', 'index')"
                    class="btn btn-lg btn-primary"
                    role="button"
                    v-text="$lang('go_to_catalog')"
                ></a>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-lg-8">
                <div class="Cart-items">
                    <div
                        class="Cart-item"
                        v-for="(item, index) in cart.items"
                        :key="index"
                    >
                        <div class="Cart-item_thumbnail">
                            <div class="Cart-item_thumbnail-image">
                                <img
                                    :src="item.product.image"
                                    :alt="item.name"
                                />
                            </div>
                            <div class="Cart-item_thumbnail-info">
                                <div class="Cart-item_thumbnail-caption">
                                    <div class="Cart-item_name">
                                        <a
                                            :href="
                                                $link('link', 'product', {
                                                    uuid: item.product.uuid,
                                                })
                                            "
                                            v-text="item.name"
                                        ></a>
                                    </div>
                                    <div class="Cart-item_unitPrice">
                                        <span
                                            v-text="item.unitPrice.formatted"
                                        ></span>
                                    </div>
                                    <div
                                        class="Cart-item_inapplicable"
                                        v-if="
                                            cart.hasCoupon && !item.hasDiscount
                                        "
                                    >
                                        <span
                                            v-text="$lang('inapplicable_item')"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Cart-item_count">
                            <div
                                class="Qty-buttons"
                                :title="$lang('quantity')"
                            >
                                <button
                                    type="button"
                                    class="minus"
                                    @click="recalc(item.id, 'minus')"
                                    :disabled="item.qty <= 1"
                                >
                                    <i class="icon-minus"></i>
                                </button>
                                <div class="qty" v-text="item.qty"></div>
                                <button
                                    type="button"
                                    class="plus"
                                    @click="recalc(item.id, 'plus')"
                                    :disabled="16 <= item.qty"
                                >
                                    <i class="icon-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="Cart-item_total">
                            <span v-text="item.total.formatted"></span>
                        </div>
                        <div class="Cart-item_remove">
                            <button
                                type="button"
                                class="Cart-item_remove-btn"
                                @click="removeitem(item.id)"
                                v-text="$lang('item_remove')"
                            ></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="Cart-order">
                    <div class="Cart-order_subtotal">
                        <span v-text="$lang('subtotal')"></span>
                        <span v-text="cart.subtotal.formatted"></span>
                    </div>
                    <div class="Cart-order_actions">
                        <button
                            type="button"
                            class="btn btn-lg btn-primary fw-bold text-white"
                            :class="{ 'btn-loading': loader }"
                            :disabled="loader"
                            @click="checkout"
                            v-text="$lang('cart_checkout_btn')"
                        ></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CartMixin from "../mixins/CartMixin";
export default {
    name: "Cart",

    props: ["link"],

    mixins: [CartMixin],
};
</script>
