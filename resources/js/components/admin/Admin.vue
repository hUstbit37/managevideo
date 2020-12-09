<template>
    <el-container>
        <el-header>Trang Admin</el-header>
        <el-container>
            <el-aside width="250px">
                <el-menu :router="true" :default-active="$route.path">
                    <el-menu-item index="/admin/category" :route="{name:'category'}">
                        <i class="el-icon-menu"></i>
                        <span>Quản lý danh mục</span>
                    </el-menu-item>
                    <el-menu-item index="/admin/product" :route="{name:'product'}">
                        <i class="el-icon-menu"></i>
                        <span>Quản lý sản phẩm</span>
                    </el-menu-item>
                    <el-menu-item index="/admin/order" :route="{name:'order'}">
                        <i class="el-icon-menu"></i>
                        <span>Quản lý đơn hàng</span>
                    </el-menu-item>
                    <el-menu-item index="2">
                        <i class="el-icon-menu"></i>
                        <span>Quản lý tài khoản</span>
                    </el-menu-item>
                </el-menu>
            </el-aside>

            <el-main>
                <router-view></router-view>
            </el-main>

        </el-container>
    </el-container>
</template>

<script>
export default {};
</script>

<style lang="scss">

.el-header {
    background-color: #B3C0D1;
    color: #333;
    text-align: center;
    line-height: 60px;
}

.el-aside {
    color: #ffffff;
    //text-align: center;
    line-height: 200px;
    ul {
        background-color: #295179;
        li{
            color: #fff;
            font-size: 16px;
        }
    }
}

.el-main {
    background-color: #E9EEF3;
    color: #333;
    text-align: center;
    line-height: 160px;
}

body > .el-container {
    margin-bottom: 40px;
}
</style>
