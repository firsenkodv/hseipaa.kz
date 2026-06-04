@props([
    'id' => 'desc-collapse-wrap'
])
<style>
    .desc-collapse-wrap {
        position: relative;
        overflow: hidden;
        transition: max-height 0.45s ease;
    }
    .desc-collapse-fade {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(to bottom, transparent, #fff);
        pointer-events: none;
        transition: opacity 0.45s ease;
    }
    .desc-collapse-btn {
        display: block;
        gap: 6px;
        font-size: 18px;
        color: #EF533F;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        font-weight: 600;
        margin: 20px auto;
    }

    .desc-collapse-btn:hover { opacity: 0.75; }
</style>
<button class="desc-collapse-btn" id="desc-collapse-btn" type="button">Развернуть</button>
<script>
    (function () {
        var COLLAPSED = 180;
        var wrap = document.getElementById('{{$id}}');
        var fade = document.getElementById('desc-collapse-fade');
        var btn  = document.getElementById('desc-collapse-btn');
        var full = wrap.scrollHeight;

        if (full <= COLLAPSED) {
            fade.style.display = 'none';
            btn.style.display  = 'none';
            return;
        }

        wrap.style.maxHeight = COLLAPSED + 'px';

        btn.addEventListener('click', function () {
            var expanded = wrap.classList.contains('is-expanded');
            if (!expanded) {
                wrap.style.maxHeight = full + 'px';
                wrap.classList.add('is-expanded');
                fade.style.opacity = '0';
                btn.textContent = 'Свернуть';
            } else {
                wrap.style.maxHeight = COLLAPSED + 'px';
                wrap.classList.remove('is-expanded');
                fade.style.opacity = '1';
                btn.textContent = 'Развернуть';
            }
        });
    })();
</script>
