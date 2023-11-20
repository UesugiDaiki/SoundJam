/**
 * plugins/vuetify.js
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
// import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

// 追記部分mdi/js
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg';
import {
  mdiAccount,
  mdiAccountGroup,
  mdiAccountOutline,
  mdiBell,
  mdiBellOutline,
  mdiCog,
  mdiCogOutline,
  mdiEmail,
  mdiEmailOutline,
  mdiGuitarPick,
  mdiGuitarPickOutline,
  mdiHome,
  mdiHomeOutline,
  mdiLogout,
  mdiMagnify,
  mdiPencil,
  mdiSpeedometer,
  mdiViewDashboard,
  mdiClose,
  mdiLogin,
  mdiPlusBoxOutline,
  mdiMusicNoteHalf,
  mdiMusicNoteEighth,
  mdiChevronUp,
  mdiChevronDown,
  mdiEye,
  mdiEyeOff,
  mdiAt,
  mdiLink,
  mdiPlus,
  mdiMinus,
  mdiCamera,
} from '@mdi/js';

// Composables
import { createVuetify } from 'vuetify'

// https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
export default createVuetify({
  icons: {
    defaultSet: "mdi",
    // エイリアス、ここに必要なアイコンを纏めて追加
    // 例）「$プロパティ名」のような形式で呼び出せる。
    aliases: {
      ...aliases,
      //NavDrawer.vue
      //アカウント
      account: mdiAccount,
      accountOutline: mdiAccountOutline,
      //ホーム
      home: mdiHome,
      homeOutline: mdiHomeOutline,
      //まぐに？
      magnify: mdiMagnify,
      //ベル
      bell: mdiBell,
      bellOutline: mdiBellOutline,
      //メールアドレス
      email: mdiEmail,
      emailOutline: mdiEmailOutline,
      //こぐ
      cog: mdiCog,
      cogOutline: mdiCogOutline,
      // ギター
      guitarPick: mdiGuitarPick,
      guitarPickOutline: mdiGuitarPickOutline,
      // ログアウト
      logout: mdiLogout,

      // HelloWorld.vue
      // ダッシュボード
      viewDashboard: mdiViewDashboard,
      // アカウントグループ
      accountGroup: mdiAccountGroup,
      // スピードメーター?
      speedometer: mdiSpeedometer,

      // InquiryButton.vue
      pencil: mdiPencil,

      // 閉じる
      close: mdiClose,

      // ログイン
      login: mdiLogin,

      // プラス、マイナス
      plus: mdiPlus,
      minus: mdiMinus,
      plusBoxOutline: mdiPlusBoxOutline,

      // いいね
      musicNoteHalf: mdiMusicNoteHalf,
      musicNoteEighth: mdiMusicNoteEighth,

      // 使用機材、録音方法の表示切替
      chevronUp: mdiChevronUp,
      chevronDown: mdiChevronDown,

      // パスワード表示切替
      eye: mdiEye,
      eyeOff: mdiEyeOff,

      // @
      at: mdiAt,

      // リンク
      link: mdiLink,

      // カメラ
      camera: mdiCamera,
    },
    sets: {
      mdi,
    }
  },
  theme: {
    themes: {
      light: {
        colors: {
          primary: '#1867C0',
          secondary: '#5CBBF6',
        },
      },
    },
  },
})
