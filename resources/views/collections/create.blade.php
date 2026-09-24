<div class="container">
    <div class="card p-4">

        <h4 class="mb-4">ایجاد مجموعه جدید</h4>

        <form action="{{ route('collections.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>نام مجموعه</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="مثلاً کتاب‌ها"
                    required
                >
            </div>

            <button class="btn btn-primary mt-3">
                ایجاد مجموعه
            </button>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">
                انصراف
            </a>
        </form>

    </div>
</div>