#!/bin/bash

# Actualizamos messages.po con nuevos mensajes en los fuentes.
xgettext -f sources.txt -L PHP -o messages.po --from-code=utf-8

# Cambiamos charset=CHARSET por charset=utf-8 en messages.po
sed -e 's/charset=CHARSET/charset=utf-8/g' messages.po > temp.po
mv temp.po messages.po

# Mezclamos.
msgmerge es_ES/LC_MESSAGES/messages.po messages.po -U
msgmerge en_GB/LC_MESSAGES/messages.po messages.po -U

emacs es_ES/LC_MESSAGES/messages.po en_GB/LC_MESSAGES/messages.po

# Compilamos los nuevos .po.
cd es_ES/LC_MESSAGES/
msgfmt -o messages.mo messages.po
cd ../../en_GB/LC_MESSAGES/
msgfmt -o messages.mo messages.po