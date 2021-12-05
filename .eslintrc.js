module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: ['@vue/airbnb', 'plugin:vue/essential'],
  parserOptions: {
    parser: 'babel-eslint',
  },
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',

    semi: ['error', 'never'],
    'import/no-cycle': ['warn'],
    'func-names': ['warn'],
    'no-unused-vars': ['warn'],
    'vue/html-self-closing': 'warn',
    'global-require': 0,
    'max-len': 'off',
    'linebreak-style': 'off',
      'indent': ['error', 4],
    "camelcase": [2, {"allow": ["^[a-zA-Z0-9_]*$"]}],
    'arrow-parens': ['error', 'as-needed'],
    'vue/multiline-html-element-content-newline': 'off'
  }
  /*rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',

    // recommended by Vetur
    'vue/html-self-closing': 'off',

    // Disable max-len
    'max-len': 'off',

    // we don't want it
    semi: ['error', 'never'],

    // add parens ony when required in arrow function
    'arrow-parens': ['error', 'as-needed'],

    // add new line above comment
    'lines-around-comment': [
      'error',
      {
        beforeBlockComment: true,
        beforeLineComment: true,
        allowBlockStart: true,
        allowClassStart: true,
        allowObjectStart: true,
        allowArrayStart: true,
      },
    ],

    'linebreak-style': 'off',

    // add new line above comment
    'newline-before-return': 'error',

    // add new line below import
    'import/newline-after-import': ['error', { count: 1 }],

    'import/extensions': [
      'error',
      'ignorePackages',
      {
        js: 'never',
        jsx: 'never',
        ts: 'never',
        tsx: 'never',
      },
    ],

    'global-require': 'off',
  },*/
}
