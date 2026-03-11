/** @type {import('tailwindcss').Config} */

module.exports = {
  // ─────────────────────────────────────────────────────────────
  // Content paths for Laravel + Blade + JS
  // ─────────────────────────────────────────────────────────────
  content: [
    // Current PHP setup
    "./**/*.php",
    "./js/**/*.js",
    // Laravel paths (enable when integrating)
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],

  theme: {
    // Keep default font-weight utilities available (font-medium, etc.)
    fontWeight: {
      thin: '100',
      extralight: '200',
      light: '300',
      normal: '400',
      medium: '500',
      semibold: '600',
      bold: '700',
      extrabold: '800',
      black: '900',
    },

    // ─────────────────────────────────────────────────────────────
    // COLORS - Semantic naming for scalability
    // ─────────────────────────────────────────────────────────────
    colors: {
      // Core brand
      primary: {
        DEFAULT: '#8BC34A',
        light: '#A8D574',
        dark: '#6B9B35',
        50: '#F4F9EC',
        100: '#EAF6D8',
      },
      dark: {
        DEFAULT: '#1E2A3A',
        light: '#2D3E52',
        darker: '#151E29',
      },
      accent: {
        DEFAULT: '#FF6A3D',
        light: '#FF8A65',
        dark: '#E55A2D',
      },

      // Surfaces & backgrounds
      background: '#F7F9FC',
      surface: '#FFFFFF',

      // Text hierarchy
      heading: '#1F2937',
      body: '#374151',
      muted: '#6B7280',

      // UI elements
      border: {
        DEFAULT: '#E5E7EB',
        light: '#F3F4F6',
        dark: '#D1D5DB',
      },

      // Status colors
      success: '#22C55E',
      warning: '#F59E0B',
      error: '#EF4444',
      info: '#3B82F6',

      // Utilities
      white: '#FFFFFF',
      black: '#000000',
      transparent: 'transparent',
      current: 'currentColor',

      // Standard Tailwind grays (for flexibility)
      gray: {
        50: '#F9FAFB',
        100: '#F3F4F6',
        200: '#E5E7EB',
        300: '#D1D5DB',
        400: '#9CA3AF',
        500: '#6B7280',
        600: '#4B5563',
        700: '#374151',
        800: '#1F2937',
        900: '#111827',
      },

      // Orange palette
      orange: {
        50: '#FFF7ED',
        100: '#FFEDD5',
        200: '#FED7AA',
        300: '#FDBA74',
        400: '#FB923C',
        500: '#F97316',
        600: '#EA580C',
        700: '#C2410C',
        800: '#9A3412',
        900: '#7C2D12',
      },

      ink: "#353C52",
      green: "#98CB46",
      coral: "#F15E42",
      panel: "#F0F3FA",
      lime: '#98CB46',
      panel: '#F0F3FA'
    },

    // ─────────────────────────────────────────────────────────────
    // TYPOGRAPHY - Fredoka (headings) + Onest (body)
    // ─────────────────────────────────────────────────────────────
    fontFamily: {
      heading: ['Fredoka', 'system-ui', 'sans-serif'],
      body: ['Onest', 'system-ui', 'sans-serif'],
      sans: ['Onest', 'system-ui', 'sans-serif'], // Default fallback
    },

    // Custom font sizes with integrated line-height
    fontSize: {
      // Headings (Fredoka)
      'h1': ['85px', { lineHeight: '96px', fontWeight: '700' }],
      'h2': ['55px', { lineHeight: '65px', fontWeight: '700' }],
      'h3': ['36px', { lineHeight: '44px', fontWeight: '600' }],
      'h4': ['28px', { lineHeight: '36px', fontWeight: '600' }],
      'h5': ['22px', { lineHeight: '30px', fontWeight: '500' }],
      'h6': ['18px', { lineHeight: '26px', fontWeight: '500' }],

      // Body text (Onest)
      'body-lg': ['19px', { lineHeight: '32px', fontWeight: '400' }],
      'body': ['16px', { lineHeight: '28px', fontWeight: '400' }],
      'body-sm': ['14px', { lineHeight: '22px', fontWeight: '400' }],
      'caption': ['12px', { lineHeight: '18px', fontWeight: '400' }],

      // UI elements
      'btn': ['16px', { lineHeight: '24px', fontWeight: '500' }],
      'btn-sm': ['14px', { lineHeight: '20px', fontWeight: '500' }],
      'label': ['14px', { lineHeight: '20px', fontWeight: '500' }],
    },

    // ─────────────────────────────────────────────────────────────
    // SPACING - 4px base scale
    // ─────────────────────────────────────────────────────────────
    spacing: {
      '0': '0',
      'px': '1px',
      '0.5': '2px',
      '1': '4px',
      '2': '8px',
      '3': '12px',
      '4': '16px',
      '5': '20px',
      '6': '24px',
      '7': '28px',
      '8': '32px',
      '9': '36px',
      '10': '40px',
      '12': '48px',
      '14': '56px',
      '16': '64px',
      '18': '72px',
      '20': '80px',
      '24': '96px',
      '28': '112px',
      '32': '128px',
      '36': '144px',
      '40': '160px',

      // Semantic spacing aliases
      'section': '64px',      // Vertical section padding
      'section-lg': '96px',   // Large section padding
      'card': '24px',         // Card internal padding
      'card-sm': '16px',      // Small card padding
    },

    // ─────────────────────────────────────────────────────────────
    // BORDER RADIUS
    // ─────────────────────────────────────────────────────────────
    borderRadius: {
      'none': '0',
      'sm': '8px',
      'DEFAULT': '12px',      // Buttons, inputs
      'md': '12px',
      'lg': '16px',           // Cards
      'xl': '20px',
      '2xl': '24px',          // Large sections
      '3xl': '32px',
      'full': '9999px',       // Pills, avatars
    },

    // ─────────────────────────────────────────────────────────────
    // BOX SHADOWS
    // ─────────────────────────────────────────────────────────────
    boxShadow: {
      'none': 'none',
      'sm': '0 2px 8px rgba(0, 0, 0, 0.04)',
      'DEFAULT': '0 4px 16px rgba(0, 0, 0, 0.06)',
      'md': '0 6px 20px rgba(0, 0, 0, 0.08)',
      'card': '0 10px 30px rgba(0, 0, 0, 0.08)',        // Card shadow
      'lg': '0 12px 40px rgba(0, 0, 0, 0.1)',
      'xl': '0 20px 50px rgba(0, 0, 0, 0.12)',
      'btn-hover': '0 4px 12px rgba(0, 0, 0, 0.15)',    // Button hover
      'inner': 'inset 0 2px 4px rgba(0, 0, 0, 0.06)',
    },

    // ─────────────────────────────────────────────────────────────
    // EXTEND (additions to defaults)
    // ─────────────────────────────────────────────────────────────
    extend: {
      // Max-width for containers
      maxWidth: {
        'container': '1600px',
        'content': '1200px',
        'narrow': '800px',
        'wide': '1400px',
      },

      // Z-index scale
      zIndex: {
        'dropdown': '100',
        'sticky': '200',
        'modal': '300',
        'toast': '400',
      },

      // Transitions
      transitionDuration: {
        'fast': '150ms',
        'DEFAULT': '200ms',
        'slow': '300ms',
      },

      // Animation
      animation: {
        'fade-in': 'fadeIn 0.3s ease-out',
        'slide-up': 'slideUp 0.3s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },

  // ─────────────────────────────────────────────────────────────
  // PLUGINS
  // ─────────────────────────────────────────────────────────────
  plugins: [],
}
