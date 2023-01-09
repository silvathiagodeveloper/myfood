export default {
    SET_TENANTS(state, tenants) {
        state.items = tenants
    },
    SET_SELECTED_TENANT(state, tenant) {
        state.selectedTenant = tenant
    },
    SET_CATEGORIES(state, categories) {
        state.categories = categories
    },
    SET_PRODUCTS(state, products) {
        state.products = products
    },
}