// = VALIDATION AND RESPONSE
export default {
    data() {
        return {
            isLoading: false,
            initialLoading: false,
        };
    },
    methods: {
        async checkStatus(data, status, type, dispatch, dispatch2) {
            if (status == 422) {
                this.UnprocEntity(data);
            } else if (status == 200) {
                if (type != 'update' || type != 'register') {
                    await this.$store.dispatch(dispatch, { page: 1, sort: this.sort });
                    await this.$store.dispatch(dispatch2, { page: 1, sort: this.sort });
                }
                this.successResponse(data);
            } else {
                this.errResponse(data);
            }
            this.isLoading = false;
        },
        UnprocEntity(data) {
            for (const key of Object.keys(data)) {
                this.$toast.error(data[key][0]);
            }
            this.isLoading = false;
        },
        successResponse(data) {
            this.closeModal();
            this.isLoading = false;
            return this.$toast.success(data.msg);
        },
        errResponse(data) {
            this.closeModal();
            this.isLoading = false;
            return this.$toast.error(data.msg);
        },
    },
};