export default {
  name: 'spinner',
  /**
   * Props the parent can use to manipulate this component.
   * Note: Components themselves should not mutate their own props.
   */
  props: {
    /**
     * The message displayed with the spinner
     */
    'message': {
      type: String,
      default: 'Loading...'
    }
  },
  data () {
    return {
    }
  },
  methods: {
  }
}