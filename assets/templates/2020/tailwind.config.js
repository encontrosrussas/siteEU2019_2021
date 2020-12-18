module.exports = {
  purge: false,
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        'mauvelous': {
          50: '#FEF9FB',
          100: '#FDF3F7',
          200: '#FBE0EC',
          300: '#F8CEE1',
          400: '#F3A9CA',
          500: '#EE84B3',
          600: '#D677A1',
          700: '#8F4F6B',
          800: '#6B3B51',
          900: '#472836',
        },

        'smalt': {
          50: '#F5F7FA',
          100: '#EBEEF6',
          200: '#CCD6E8',
          300: '#ADBDDB',
          400: '#708BBF',
          500: '#3359A4',
          600: '#2E5094',
          700: '#1F3562',
          800: '#17284A',
          900: '#0F1B31',
        },
        'whitesmoke': {
          50: '#FEFEFE',
          100: '#FEFEFE',
          200: '#FCFCFC',
          300: '#F9F9F9',
          400: '#F5F5F5',
          500: '#F1F1F1',
          600: '#D9D9D9',
          700: '#919191',
          800: '#6C6C6C',
          900: '#484848',
        },
        'maire': {
          50: '#F4F4F4',
          100: '#E8E8E8',
          200: '#C7C7C6',
          300: '#A5A5A4',
          400: '#61615F',
          500: '#1D1D1B',
          600: '#1A1A18',
          700: '#111110',
          800: '#0D0D0C',
          900: '#090908',
        },
        'chocolate': {
          50: '#FEF6F3',
          100: '#FDEEE8',
          200: '#F9D4C5',
          300: '#F6BBA2',
          400: '#EF875D',
          500: '#E85417',
          600: '#D14C15',
          700: '#8B320E',
          800: '#68260A',
          900: '#461907',
        }
      },
      backgroundImage: theme => ({
        'cronograma': "url('../../dist/images/bg_cronograma.svg')",
        '2020-1': "url('../../dist/images/rodape_2020_1.svg')",
        '2020-2': "url('../../dist/images/rodape_2020_2.svg')",
        'depoimento': "url('../../dist/images/setas.svg')",
        'formas': "url('../../dist/images/formas.svg')",
        'seta': "url('../../dist/images/seta_deslize.svg')",
        'dinamismo': "url('../../dist/images/dinamismo.svg')",
      }),
      spacing: {
        '15': '3.813rem',
        '21': '5.625rem',
        '24.5': '6.625rem',
        '40.5': '10.625rem',
        '41': '10.688rem',
        '57': '14.125rem',
      },
      animation: {
        'fade-in-up': 'fade-in-up 1s',
        'smooth-bounce': 'smooth-bounce 3s infinite ease-in-out'
      },
      keyframes: {
        'fade-in-up': {
          '0%': {
            'opacity': '0',
            'transform': 'translate3d(0, 35%, 0)'
          },
          '100%': {
            'opacity': '1',
            'transform': 'translate3d(0, 0, 0)'
          }
        },
        'smooth-bounce': {
          '0%': {
            transform: 'translateY(-5px)',
          },
          '50%': {
            transform: 'translateY(10px)'
          },
          '100%': {
            transform: 'translateY(-5px)'
          }
        }
      }
    },
    fontFamily: {
      'sans': ['MuseoModerno', 'cursive']
    },
    tooltipArrows: theme => ({
      'timeline-arrow': {
          borderColor: theme('colors.maire.500'),
          borderWidth: 1,
          backgroundColor: theme('colors.white'),
          size: 10,
          offset: 10
      },
  }),
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('tailwindcss-tooltip-arrow-after')()
  ],
}