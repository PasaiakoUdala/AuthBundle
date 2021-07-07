# Pasaiako Udala Auth Bundle

### Instalatzeko

`composer require pasaiakoudala/authbundle`

Gehitu ondoko aldagaiak .env fitxategian eta balio egokiak ezarri:

    LDAP_IP=172.28.XXX.XXX
    LDAP_BASE_DN=DC=DOMAIN,DC=net
    LDAP_SEARCH_DN=CN=LDAPUPSER,CN=Users,DC=pasaia,DC=net
    LDAP_PASSWD=LDAPPASSWD

Joan `config|packages` karpetara eta sortu `pasaiako_udala_auth.yaml` izeneko fitxategia ondoko aldagaiekin eta balio egookiak zehaztu:

    pasaiako_udala_auth:
      LDAP_ADMIN_TALDEAK: "Rol-taldea1, Rol-taldea2"
      LDAP_KUDEATU_TALDEAK: "Rol-taldea1, Rol-taldea2"
      LDAP_USER_TALDEA: "Rol-taldea1, Rol-taldea2"
      route_after_successfull_login: "default2"

Base datuan User taula sortzeko momentua:
`docker-compose exec app php bin/console doctrine:schema:update --force --dump-sql`