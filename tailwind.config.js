/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        // Palet Toko Utama (Krem & Slate)
        percaBg: '#FAF7F2',
        percaDark: '#2C3A3F',
        percaTerracotta: '#C07A65',
        percaSage: '#879685',
        percaBlue: '#4F6774',
        percaBorder: '#EBE5DC',

        // Palet Baru Admin Panel (Pink & Mauve)
        brandBg: '#FDF8F9',          // Background blush pink sangat lembut
        brandPinkLight: '#FCE7EC',    // Border & container pink pastel
        brandMauve: '#B86B7F',        // Dusty mauve untuk tombol & aksen ikon
        brandDeep: '#2D1F25',         // Judul & teks gelap berbobot
        brandText: '#5A4950',         // Teks sekunder
      },
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'serif'],
        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
      }
    },
  },
  plugins: [],
}