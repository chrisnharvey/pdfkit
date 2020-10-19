#define FFI_SCOPE "wkhtmltox"
#define FFI_LIB "libwkhtmltox.so"

/* -*- mode: c++; tab-width: 4; indent-tabs-mode: t; eval: (progn (c-set-style "stroustrup") (c-set-offset 'innamespace 0)); -*-
 * vi:set ts=4 sts=4 sw=4 noet :
 *
 * Copyright 2010-2020 wkhtmltopdf authors
 *
 * This file is part of wkhtmltopdf.
 *
 * wkhtmltopdf is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * wkhtmltopdf is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with wkhtmltopdf.  If not, see <http: *www.gnu.org/licenses/>.
 */

// #ifndef __PDF_H__
// #define __PDF_H__

// #ifdef BUILDING_WKHTMLTOX
// #include "dllbegin.inc"
// #else
// #include <wkhtmltox/dllbegin.inc>
// #endif

struct wkhtmltopdf_global_settings;
typedef struct wkhtmltopdf_global_settings wkhtmltopdf_global_settings;

struct wkhtmltopdf_object_settings;
typedef struct wkhtmltopdf_object_settings wkhtmltopdf_object_settings;

struct wkhtmltopdf_converter;
typedef struct wkhtmltopdf_converter wkhtmltopdf_converter;

typedef void (*wkhtmltopdf_str_callback)(wkhtmltopdf_converter * converter, const char * str);
typedef void (*wkhtmltopdf_int_callback)(wkhtmltopdf_converter * converter, const int val);
typedef void (*wkhtmltopdf_void_callback)(wkhtmltopdf_converter * converter);

extern int wkhtmltopdf_init(int use_graphics);
extern int wkhtmltopdf_deinit();
extern int wkhtmltopdf_extended_qt();
extern const char * wkhtmltopdf_version();

extern wkhtmltopdf_global_settings * wkhtmltopdf_create_global_settings();
extern void wkhtmltopdf_destroy_global_settings(wkhtmltopdf_global_settings *);

extern wkhtmltopdf_object_settings * wkhtmltopdf_create_object_settings();
extern void wkhtmltopdf_destroy_object_settings(wkhtmltopdf_object_settings *);

extern int wkhtmltopdf_set_global_setting(wkhtmltopdf_global_settings * settings, const char * name, const char * value);
extern int wkhtmltopdf_get_global_setting(wkhtmltopdf_global_settings * settings, const char * name, char * value, int vs);
extern int wkhtmltopdf_set_object_setting(wkhtmltopdf_object_settings * settings, const char * name, const char * value);
extern int wkhtmltopdf_get_object_setting(wkhtmltopdf_object_settings * settings, const char * name, char * value, int vs);


extern wkhtmltopdf_converter * wkhtmltopdf_create_converter(wkhtmltopdf_global_settings * settings);
extern void wkhtmltopdf_destroy_converter(wkhtmltopdf_converter * converter);

extern void wkhtmltopdf_set_warning_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_str_callback cb);
extern void wkhtmltopdf_set_error_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_str_callback cb);
extern void wkhtmltopdf_set_phase_changed_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_void_callback cb);
extern void wkhtmltopdf_set_progress_changed_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_int_callback cb);
extern void wkhtmltopdf_set_finished_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_int_callback cb);
extern int wkhtmltopdf_convert(wkhtmltopdf_converter * converter);
extern void wkhtmltopdf_add_object(wkhtmltopdf_converter * converter, wkhtmltopdf_object_settings * setting, const char * data);

extern int wkhtmltopdf_current_phase(wkhtmltopdf_converter * converter);
extern int wkhtmltopdf_phase_count(wkhtmltopdf_converter * converter);
extern const char * wkhtmltopdf_phase_description(wkhtmltopdf_converter * converter, int phase);
extern const char * wkhtmltopdf_progress_string(wkhtmltopdf_converter * converter);
extern int wkhtmltopdf_http_error_code(wkhtmltopdf_converter * converter);
extern long wkhtmltopdf_get_output(wkhtmltopdf_converter * converter, const unsigned char **);

// #ifdef BUILDING_WKHTMLTOX
// #include "dllend.inc"
// #else
// #include <wkhtmltox/dllend.inc>
// #endif

// #endif /*__PDF_H__*/
