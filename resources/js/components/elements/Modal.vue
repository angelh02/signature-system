<template>
    <div
        id="signup-modal"
        class="modal"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mt-2 mb-4">
                        
                    </div>

                    <form class="ps-3 pe-3" action="#">
                        <div class="mb-3">
                            <label for="username" class="form-label"
                                >Name</label
                            >
                            <input
                                class="form-control"
                                type="email"
                                id="username"
                                required=""
                                placeholder="Michael Zenaty"
                            />
                        </div>

                        <div class="mb-3">
                            <label for="emailaddress" class="form-label"
                                >Email address</label
                            >
                            <input
                                class="form-control"
                                type="email"
                                id="emailaddress"
                                required=""
                                placeholder="john@deo.com"
                            />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"
                                >Password</label
                            >
                            <input
                                class="form-control"
                                type="password"
                                required=""
                                id="password"
                                placeholder="Enter your password"
                            />
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="customCheck1"
                                />
                                <label
                                    class="form-check-label"
                                    for="customCheck1"
                                    >I accept
                                    <a href="#">Terms and Conditions</a></label
                                >
                            </div>
                        </div>

                        <div class="mb-3 text-center">
                            <button
                                class="btn btn-primary"
                                type="button"
                                @click="close"
                            >
                                Sign Up Free
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ModalComponent",
    data() {
        return {
            resetValues: false,
        };
    },
    methods: {
        close() {
            this.$emit("close");
        },
    },
};
</script>
