<template>
    <div>
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-7">
                        <h1>Preparacion de documento</h1>
                        <h2>Añadir participantes</h2>
                    </div>
                    <div class="col-4 py-2">
                        <ul
                            class="nav nav-pills bg-nav-pills nav-justified mb-3"
                        >
                            <li class="nav-item">
                                <a
                                    href="#home1"
                                    data-bs-toggle="tab"
                                    aria-expanded="false"
                                    class="nav-link rounded-0"
                                >
                                    <i
                                        class="mdi mdi-home-variant d-md-none d-block"
                                    ></i>
                                    <span class="d-none d-md-block">Home</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    href="#profile1"
                                    data-bs-toggle="tab"
                                    aria-expanded="true"
                                    class="nav-link rounded-0 active"
                                >
                                    <i
                                        class="mdi mdi-account-circle d-md-none d-block"
                                    ></i>
                                    <span class="d-none d-md-block"
                                        >Profile</span
                                    >
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane" id="home1">
                        <p>Holña</p>
                    </div>
                    <div class="tab-pane show active" id="profile1">
                        <p>PPP</p>
                    </div>
                </div>
            </div>

            <div
                class="col-4 row justify-content-center py-2"
                style="background-color: #bbb"
            >
                <div class="">
                    <div class="card">
                        <h6 class="card-header">Featured</h6>
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">
                                With supporting text below as a natural lead-in
                                to additional content.
                            </p>
                            <a
                                href="javascript: void(0);"
                                class="btn btn-primary"
                                >Go somewhere</a
                            >
                        </div>
                        <!-- end card-body-->
                    </div>
                    <!-- end card-->
                </div>
            </div>
        </div>
    </div>
</template>
