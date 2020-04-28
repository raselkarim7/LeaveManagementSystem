(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/authentication/Login.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/authentication/Login.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _services_auth_service__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../services/auth_service */ "./resources/js/services/auth_service.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'Login',
  data: function data() {
    return {
      submitingToServer: false,
      user: {
        email: '',
        password: '',
        remember_me: false
      },
      errors: {}
    };
  },
  mounted: function mounted() {
    // console.log('Login.vue === mounted...')
    document.querySelector('body').style.backgroundColor = '#343a40';
  },
  destroyed: function destroyed() {
    // console.log('Login.vue === destroyed...')
    document.querySelector('body').style.backgroundColor = 'transparent';
  },
  methods: {
    handleLogin: function () {
      var _handleLogin = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                console.log('inside login....');
                this.submitingToServer = true;
                _context.prev = 2;
                _context.next = 5;
                return _services_auth_service__WEBPACK_IMPORTED_MODULE_1__["login"](this.user);

              case 5:
                response = _context.sent;
                this.submitingToServer = false;
                this.errors = {};
                this.$store.dispatch('setToken', response);
                this.fethUserNow();
                console.log('Login.vue Response =========>>> ', response);
                _context.next = 29;
                break;

              case 13:
                _context.prev = 13;
                _context.t0 = _context["catch"](2);
                this.submitingToServer = false;
                console.log('Login.vue Error ========= ', _context.t0, _context.t0.response);
                _context.t1 = _context.t0.response.status;
                _context.next = _context.t1 === 422 ? 20 : _context.t1 === 401 ? 23 : _context.t1 === 500 ? 25 : 27;
                break;

              case 20:
                this.errors = _context.t0.response.data.errors;
                console.log('errors =========== ', this.errors);
                return _context.abrupt("break", 29);

              case 23:
                this.flashMessage.error({
                  message: _context.t0.response.data.message,
                  time: 3000
                });
                return _context.abrupt("break", 29);

              case 25:
                this.flashMessage.error({
                  message: _context.t0.response.data.message,
                  time: 2000
                });
                return _context.abrupt("break", 29);

              case 27:
                this.flashMessage.error({
                  message: 'Some error occured, Please Try again',
                  time: 3000
                });
                return _context.abrupt("break", 29);

              case 29:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this, [[2, 13]]);
      }));

      function handleLogin() {
        return _handleLogin.apply(this, arguments);
      }

      return handleLogin;
    }(),
    fethUserNow: function () {
      var _fethUserNow = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.prev = 0;
                _context2.next = 3;
                return _services_auth_service__WEBPACK_IMPORTED_MODULE_1__["getUser"]();

              case 3:
                response = _context2.sent;
                console.log('user --------> ', response.data);
                this.$store.dispatch('setUser', response.data);
                _context2.next = 11;
                break;

              case 8:
                _context2.prev = 8;
                _context2.t0 = _context2["catch"](0);
                console.log('wwwwwwww ----------> ', _context2.t0, _context2.t0.response);

              case 11:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this, [[0, 8]]);
      }));

      function fethUserNow() {
        return _fethUserNow.apply(this, arguments);
      }

      return fethUserNow;
    }()
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/authentication/Login.vue?vue&type=template&id=bb641d1e&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/authentication/Login.vue?vue&type=template&id=bb641d1e& ***!
  \******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row justify-content-center" }, [
      _c("div", { staticClass: "col-lg-5" }, [
        _c("div", { staticClass: "card shadow-lg border-0 rounded-lg mt-5" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "card-body" }, [
            _c("form", [
              _c("div", { staticClass: "form-group" }, [
                _c(
                  "label",
                  { staticClass: "small mb-1", attrs: { for: "email" } },
                  [_vm._v("Email")]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.user.email,
                      expression: "user.email"
                    }
                  ],
                  staticClass: "form-control py-4",
                  attrs: {
                    id: "email",
                    type: "email",
                    placeholder: "Enter email address"
                  },
                  domProps: { value: _vm.user.email },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.user, "email", $event.target.value)
                    }
                  }
                }),
                _vm._v(" "),
                _vm.errors.email
                  ? _c("div", { staticClass: "d-block invalid-feedback" }, [
                      _vm._v(" " + _vm._s(_vm.errors.email[0]) + " ")
                    ])
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group" }, [
                _c(
                  "label",
                  { staticClass: "small mb-1", attrs: { for: "password" } },
                  [_vm._v("Password")]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.user.password,
                      expression: "user.password"
                    }
                  ],
                  staticClass: "form-control py-4",
                  attrs: {
                    id: "password",
                    type: "password",
                    placeholder: "Enter password"
                  },
                  domProps: { value: _vm.user.password },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.user, "password", $event.target.value)
                    }
                  }
                }),
                _vm._v(" "),
                _vm.errors.password
                  ? _c("div", { staticClass: "d-block  invalid-feedback" }, [
                      _vm._v(" " + _vm._s(_vm.errors.password[0]) + " ")
                    ])
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group" }, [
                _c("div", { staticClass: "custom-control custom-checkbox" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.user.remember_me,
                        expression: "user.remember_me"
                      }
                    ],
                    staticClass: "custom-control-input",
                    attrs: { id: "rememberPasswordCheck", type: "checkbox" },
                    domProps: {
                      checked: Array.isArray(_vm.user.remember_me)
                        ? _vm._i(_vm.user.remember_me, null) > -1
                        : _vm.user.remember_me
                    },
                    on: {
                      change: function($event) {
                        var $$a = _vm.user.remember_me,
                          $$el = $event.target,
                          $$c = $$el.checked ? true : false
                        if (Array.isArray($$a)) {
                          var $$v = null,
                            $$i = _vm._i($$a, $$v)
                          if ($$el.checked) {
                            $$i < 0 &&
                              _vm.$set(
                                _vm.user,
                                "remember_me",
                                $$a.concat([$$v])
                              )
                          } else {
                            $$i > -1 &&
                              _vm.$set(
                                _vm.user,
                                "remember_me",
                                $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                              )
                          }
                        } else {
                          _vm.$set(_vm.user, "remember_me", $$c)
                        }
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "label",
                    {
                      staticClass: "custom-control-label",
                      attrs: { for: "rememberPasswordCheck" }
                    },
                    [_vm._v("Remember password")]
                  )
                ])
              ]),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "form-group d-flex align-items-left justify-content-between mt-4 mb-0"
                },
                [
                  _c(
                    "router-link",
                    { staticClass: "small", attrs: { to: "/reset-password" } },
                    [_vm._v("Forgot Password?")]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary",
                      attrs: { disabled: _vm.submitingToServer },
                      on: { click: _vm.handleLogin }
                    },
                    [_vm._v("Login")]
                  )
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "card-footer text-center" }, [
            _c(
              "div",
              { staticClass: "small" },
              [
                _c("router-link", { attrs: { to: "/register" } }, [
                  _vm._v("Need an account? Sign up!")
                ])
              ],
              1
            )
          ])
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("h3", { staticClass: "text-center font-weight-light my-4" }, [
        _vm._v("Login")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/services/auth_service.js":
/*!***********************************************!*\
  !*** ./resources/js/services/auth_service.js ***!
  \***********************************************/
/*! exports provided: login, getUser */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "login", function() { return login; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getUser", function() { return getUser; });
/* harmony import */ var _http_service__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./http_service */ "./resources/js/services/http_service.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _utils_storage__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/storage */ "./resources/js/utils/storage.js");



function login(data) {
  return new Promise(function (resolve, reject) {
    Object(_http_service__WEBPACK_IMPORTED_MODULE_0__["http"])().post('auth/login', data).then(function (response) {
      console.log('response..... ', response);
      var _response$data = response.data,
          token_type = _response$data.token_type,
          access_token = _response$data.access_token;
      var AUTH_TOKEN = "".concat(token_type, " ").concat(access_token);
      axios__WEBPACK_IMPORTED_MODULE_1___default.a.defaults.headers.common['Authorization'] = AUTH_TOKEN;
      _utils_storage__WEBPACK_IMPORTED_MODULE_2__["default"].token.setToken(AUTH_TOKEN);
      resolve(AUTH_TOKEN);
    })["catch"](function (error) {
      reject(error);
    });
  });
}
function getUser() {
  return new Promise(function (resolve, reject) {
    Object(_http_service__WEBPACK_IMPORTED_MODULE_0__["http"])().get('auth/user').then(function (res) {
      var _res$data = res.data,
          id = _res$data.id,
          name = _res$data.name,
          email = _res$data.email;
      var user = {
        id: id,
        name: name,
        email: email
      };
      var roles = res.data.roles;
      _utils_storage__WEBPACK_IMPORTED_MODULE_2__["default"].user.setUser(user);
      _utils_storage__WEBPACK_IMPORTED_MODULE_2__["default"].roles.setRoles(roles);
      resolve(res);
    })["catch"](function (error) {
      reject(error);
    });
  });
}

/***/ }),

/***/ "./resources/js/views/authentication/Login.vue":
/*!*****************************************************!*\
  !*** ./resources/js/views/authentication/Login.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Login_vue_vue_type_template_id_bb641d1e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Login.vue?vue&type=template&id=bb641d1e& */ "./resources/js/views/authentication/Login.vue?vue&type=template&id=bb641d1e&");
/* harmony import */ var _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Login.vue?vue&type=script&lang=js& */ "./resources/js/views/authentication/Login.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Login_vue_vue_type_template_id_bb641d1e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Login_vue_vue_type_template_id_bb641d1e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/authentication/Login.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/authentication/Login.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/views/authentication/Login.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/authentication/Login.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/authentication/Login.vue?vue&type=template&id=bb641d1e&":
/*!************************************************************************************!*\
  !*** ./resources/js/views/authentication/Login.vue?vue&type=template&id=bb641d1e& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_bb641d1e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Login.vue?vue&type=template&id=bb641d1e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/authentication/Login.vue?vue&type=template&id=bb641d1e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_bb641d1e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Login_vue_vue_type_template_id_bb641d1e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);