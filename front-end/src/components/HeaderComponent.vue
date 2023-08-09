<template>
    <div>
        <div class="headercomponent">
            <h1>
                {{ message }}
            </h1>
        </div>
    </div>
</template>
<script>

export default {
  name: 'HeaderComponnent',
  props: {
    message: String
  }
}
</script>