<div class="offcanvas offcanvas-start" tabindex="-1" id="menu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
            <div>
                <div class="text-center mb-4">
                    <div>Ваш населенный пункт</div>
                    <div class="fw-bold" data-bs-toggle="modal" data-bs-target="#city">{{session()->has('city.name') ?
                        session('city.name') : 'Выберите населенный пункт'}}</div>
                </div>
                <div class="Menu">
                    <div class="mt-4">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center bb-line">
                                <div class="ms-2"><a href="/delivery">Доставка и оплата</a></div>
                            </li>
                            <li class="d-flex align-items-center bb-line">
                                <div class="ms-2"><a href="/documents">Документы</a></div>
                            </li>
                            <li class="d-flex align-items-center bb-line">
                                <div class="ms-2"><a href="/addresses">Мои адреса</a></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>